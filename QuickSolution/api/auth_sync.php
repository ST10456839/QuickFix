<?php
/**
 * POST /api/v1/auth_sync.php
 *
 * Called once after sign-in or registration. Verifies the Firebase ID token and
 * creates or updates the app_user mirror row. Returns the stored profile so the
 * demonstration video can show the same identity in the authentication service,
 * the API response and the database.
 */
declare(strict_types=1);
require __DIR__ . '/bootstrap.php';

requireMethod('POST');

$user = requireUser();
$body = jsonBody();

$phone = isset($body['phone']) ? Validate::normalisePhone((string) $body['phone']) : null;
if ($phone !== null && $phone !== '' && !preg_match('/^0\d{9}$/', $phone)) {
    fail('Please check the highlighted fields.', 422,
        ['phone' => 'Please enter a valid 10-digit South African number.']);
}

if (!empty($body['full_name']) || $phone) {
    db()->prepare(
        'UPDATE app_user
            SET full_name = COALESCE(NULLIF(:name, ""), full_name),
                phone     = COALESCE(NULLIF(:phone, ""), phone)
          WHERE user_id = :id'
    )->execute([
        ':name'  => trim((string) ($body['full_name'] ?? '')),
        ':phone' => $phone ?? '',
        ':id'    => $user['user_id'],
    ]);
}

$stmt = db()->prepare(
    'SELECT user_id, firebase_uid, full_name, email, phone, auth_provider
       FROM app_user WHERE user_id = :id'
);
$stmt->execute([':id' => $user['user_id']]);

ok($stmt->fetch(), 'Profile synchronised.');
