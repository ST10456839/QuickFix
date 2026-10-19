<?php
/**
 * GET /api/v1/track.php/{reference}
 *
 * Returns the current status and the full status history for a booking. The
 * reference may be a QuickFix reference or the phone number used to book.
 */
declare(strict_types=1);
require __DIR__ . '/bootstrap.php';

requireMethod('GET');
$user = requireUser();

$path = trim((string) ($_SERVER['PATH_INFO'] ?? ''), '/');
$reference = strtoupper($path !== '' ? $path : trim((string) ($_GET['reference'] ?? '')));

if ($reference === '') {
    fail('Please supply a reference number.', 422,
        ['reference' => 'Enter a reference number or phone number.']);
}

$isReference = (bool) preg_match('/^QF-\d{4}-\d{5}$/', $reference);
$phone = Validate::normalisePhone($reference);

if (!$isReference && !preg_match('/^0\d{9}$/', $phone)) {
    fail('Please check the reference you entered.', 422,
        ['reference' => 'Enter a reference such as QF-2026-00042, or your phone number.']);
}

$stmt = db()->prepare(
    'SELECT booking_id, reference, device_brand, device_model, status, submitted_date
       FROM repair_booking
      WHERE user_id = :user_id
        AND (reference = :reference OR phone = :phone)
      ORDER BY submitted_date DESC
      LIMIT 1'
);
$stmt->execute([
    ':user_id'   => $user['user_id'],
    ':reference' => $isReference ? $reference : '',
    ':phone'     => $isReference ? '' : $phone,
]);
$booking = $stmt->fetch();

if (!$booking) {
    fail('We could not find a repair with those details on your account.', 404);
}

$history = db()->prepare(
    'SELECT status, note, changed_at FROM booking_status_history
      WHERE booking_id = :id ORDER BY changed_at ASC'
);
$history->execute([':id' => $booking['booking_id']]);

ok([
    'reference'      => $booking['reference'],
    'device'         => trim($booking['device_brand'] . ' ' . $booking['device_model']),
    'status'         => $booking['status'],
    'submitted_date' => $booking['submitted_date'],
    'history'        => array_map(static fn (array $row): array => [
        'status'     => $row['status'],
        'changed_at' => $row['changed_at'],
        'note'       => $row['note'],
    ], $history->fetchAll()),
]);
