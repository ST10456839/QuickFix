<?php
/** POST /api/v1/trade_in.php - submit a trade-in / buy-back valuation request. */
declare(strict_types=1);
require __DIR__ . '/bootstrap.php';

requireMethod('POST');
$user = requireUser();
$body = jsonBody();

$errors = Validate::check($body, [
    'device_type'        => 'required|in:Laptop,iPhone',
    'condition'          => 'required|in:Poor,Fair,Good,Excellent',
    'brand_model'        => 'required|min:3|max:200',
    'storage_capacity'   => 'required|min:2|max:50',
    'full_name'          => 'required|min:2|max:150',
    'phone'              => 'required|phone',
    'email'              => 'required|email|max:255',
    'faults_description' => 'required|min:10',
]);

if ($errors) {
    fail('Please check the highlighted fields.', 422, $errors);
}

try {
    $stmt = db()->prepare(
        'INSERT INTO trade_in_request
            (user_id, device_type, device_condition, brand_model, storage_capacity,
             full_name, phone, email, faults_description)
         VALUES (:user_id, :type, :condition, :model, :storage,
                 :name, :phone, :email, :faults)'
    );
    $stmt->execute([
        ':user_id'   => $user['user_id'],
        ':type'      => (string) $body['device_type'],
        ':condition' => (string) $body['condition'],
        ':model'     => trim((string) $body['brand_model']),
        ':storage'   => trim((string) $body['storage_capacity']),
        ':name'      => trim((string) $body['full_name']),
        ':phone'     => Validate::normalisePhone((string) $body['phone']),
        ':email'     => trim((string) $body['email']),
        ':faults'    => trim((string) $body['faults_description']),
    ]);
    $requestId = (int) db()->lastInsertId();
} catch (PDOException $e) {
    error_log('QuickFix trade-in insert failed: ' . $e->getMessage());
    fail('We could not save your request. Please try again.', 500);
}

logNotification('TradeInRequest', $requestId, trim((string) $body['email']), 'VisitorConfirmation', true);
logNotification('TradeInRequest', $requestId, 'support@quickfix.co.za', 'AdminAlert', true);

$stmt = db()->prepare('SELECT * FROM trade_in_request WHERE request_id = :id');
$stmt->execute([':id' => $requestId]);

ok($stmt->fetch(), 'Trade-in request received. We will contact you with a valuation.');
