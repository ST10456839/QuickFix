<?php
/**
 * GET  /api/v1/bookings.php  - the signed-in customer's own bookings
 * POST /api/v1/bookings.php  - create a repair booking
 */
declare(strict_types=1);
require __DIR__ . '/bootstrap.php';

requireMethod('GET', 'POST');
$user = requireUser();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = db()->prepare(
        'SELECT booking_id, reference, full_name, phone, email, device_brand, device_model,
                primary_issue, description, status, submitted_date
           FROM repair_booking
          WHERE user_id = :id
          ORDER BY submitted_date DESC'
    );
    $stmt->execute([':id' => $user['user_id']]);
    ok($stmt->fetchAll());
}

$body = jsonBody();

$allowedIssues = 'Screen Damage,Battery Issues,Slow Performance,Water Damage,'
    . 'Data Recovery,Motherboard Fault,Other';

$errors = Validate::check($body, [
    'full_name'     => 'required|min:2|max:150',
    'phone'         => 'required|phone',
    'email'         => 'required|email|max:255',
    'device_brand'  => 'required|min:2|max:100',
    'device_model'  => 'required|min:2|max:150',
    'primary_issue' => 'required|in:' . $allowedIssues,
    'description'   => 'required|min:20',
]);

if ($errors) {
    fail('Please check the highlighted fields.', 422, $errors);
}

$pdo = db();
$pdo->beginTransaction();

try {
    $reference = sprintf('QF-%s-%05d', date('Y'), random_int(1, 99999));

    $stmt = $pdo->prepare(
        'INSERT INTO repair_booking
            (reference, user_id, full_name, phone, email, device_brand, device_model,
             primary_issue, description)
         VALUES (:reference, :user_id, :full_name, :phone, :email, :brand, :model,
                 :issue, :description)'
    );
    $stmt->execute([
        ':reference'   => $reference,
        ':user_id'     => $user['user_id'],
        ':full_name'   => trim((string) $body['full_name']),
        ':phone'       => Validate::normalisePhone((string) $body['phone']),
        ':email'       => trim((string) $body['email']),
        ':brand'       => trim((string) $body['device_brand']),
        ':model'       => trim((string) $body['device_model']),
        ':issue'       => (string) $body['primary_issue'],
        ':description' => trim((string) $body['description']),
    ]);

    $bookingId = (int) $pdo->lastInsertId();

    $pdo->prepare(
        'INSERT INTO booking_status_history (booking_id, status, note, changed_by)
         VALUES (:id, :status, :note, :by)'
    )->execute([
        ':id'     => $bookingId,
        ':status' => 'New',
        ':note'   => 'Booking received from the mobile app.',
        ':by'     => 'system',
    ]);

    $pdo->commit();
} catch (PDOException $e) {
    $pdo->rollBack();
    error_log('QuickFix booking insert failed: ' . $e->getMessage());
    fail('We could not save your booking. Please try again.', 500);
}

logNotification('RepairBooking', $bookingId, trim((string) $body['email']), 'VisitorConfirmation', true);
logNotification('RepairBooking', $bookingId, 'support@quickfix.co.za', 'AdminAlert', true);

$stmt = db()->prepare('SELECT * FROM repair_booking WHERE booking_id = :id');
$stmt->execute([':id' => $bookingId]);

ok($stmt->fetch(), 'Booking received.');
