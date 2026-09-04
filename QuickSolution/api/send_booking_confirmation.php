<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed. Use POST.']);
    exit;
}

require_once __DIR__ . '/../db_connect.php';
require_once __DIR__ . '/../receipt_pdf.php';

$reference = trim($_POST['reference'] ?? '');
if (empty($reference)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Reference parameter is required.']);
    exit;
}

$stmt = $conn->prepare("SELECT * FROM bookings WHERE reference_number = ? LIMIT 1");
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'DB prepare failed.']);
    exit;
}

$stmt->bind_param('s', $reference);
$stmt->execute();
$result = $stmt->get_result();
if (!$result || $result->num_rows === 0) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Booking not found.']);
    $stmt->close();
    $conn->close();
    exit;
}

$booking = $result->fetch_assoc();
$stmt->close();

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$trackingPage = $protocol . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . '/track-repair.php?ref=' . urlencode($reference);

$sent = sendReceiptEmail($booking['email'], $booking['full_name'], $booking, $trackingPage);

echo json_encode([
    'success' => (bool)$sent,
    'message' => $sent ? 'Confirmation email sent.' : 'Failed to send email.'
]);

$conn->close();
exit;

?>
