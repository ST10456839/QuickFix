<?php
/** POST /api/v1/enquiries.php - submit a pre-owned device purchase enquiry. */
declare(strict_types=1);
require __DIR__ . '/bootstrap.php';

requireMethod('POST');
$user = requireUser();
$body = jsonBody();

$errors = Validate::check($body, [
    'full_name'     => 'required|min:2|max:150',
    'phone'         => 'required|phone',
    'email'         => 'required|email|max:255',
    'device_wanted' => 'required|in:Laptop,Phone',
    'budget'        => 'required|positive',
    'main_use'      => 'required|min:3|max:150',
]);

if ($errors) {
    fail('Please check the highlighted fields.', 422, $errors);
}

$budget = (float) str_replace([' ', ',', 'R'], '', (string) $body['budget']);

try {
    $stmt = db()->prepare(
        'INSERT INTO purchase_enquiry
            (user_id, full_name, phone, email, device_wanted, budget,
             preferred_brand, main_use, additional_preferences)
         VALUES (:user_id, :name, :phone, :email, :wanted, :budget,
                 :brand, :use, :prefs)'
    );
    $stmt->execute([
        ':user_id' => $user['user_id'],
        ':name'    => trim((string) $body['full_name']),
        ':phone'   => Validate::normalisePhone((string) $body['phone']),
        ':email'   => trim((string) $body['email']),
        ':wanted'  => (string) $body['device_wanted'],
        ':budget'  => $budget,
        ':brand'   => trim((string) ($body['preferred_brand'] ?? '')) ?: null,
        ':use'     => trim((string) $body['main_use']),
        ':prefs'   => trim((string) ($body['additional_preferences'] ?? '')) ?: null,
    ]);
    $enquiryId = (int) db()->lastInsertId();
} catch (PDOException $e) {
    error_log('QuickFix enquiry insert failed: ' . $e->getMessage());
    fail('We could not save your enquiry. Please try again.', 500);
}

logNotification('PurchaseEnquiry', $enquiryId, trim((string) $body['email']), 'VisitorConfirmation', true);
logNotification('PurchaseEnquiry', $enquiryId, 'support@quickfix.co.za', 'AdminAlert', true);

$stmt = db()->prepare('SELECT * FROM purchase_enquiry WHERE enquiry_id = :id');
$stmt->execute([':id' => $enquiryId]);

ok($stmt->fetch(), 'Enquiry received. We will check our stock and contact you.');
