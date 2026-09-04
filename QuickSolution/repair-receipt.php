<?php
require_once 'db_connect.php';

$reference = strtoupper(trim($_GET['ref'] ?? ''));
if (!preg_match('/^QF-[A-Z0-9]{6}$/', $reference)) {
    http_response_code(400);
    exit('Invalid booking reference.');
}

$stmt = $conn->prepare('SELECT reference_number, full_name, phone, email, laptop_brand, laptop_model, repair_category, issue_description, repair_date, time_slot, service_option, collection_address, status, staff_note, created_at FROM bookings WHERE reference_number = ? LIMIT 1');
$stmt->bind_param('s', $reference);
$stmt->execute();
$booking = $stmt->get_result()->fetch_assoc();
$stmt->close();
$conn->close();

if (!$booking) {
    http_response_code(404);
    exit('Booking not found.');
}

if (($_GET['format'] ?? '') === 'pdf') {
    $pdf_lines = [
        'Laptop repair booking receipt',
        '',
        'Reference: ' . $booking['reference_number'],
        'Status: ' . $booking['status'],
        '',
        'CUSTOMER',
        'Name: ' . $booking['full_name'],
        'Phone: ' . $booking['phone'],
        'Email: ' . $booking['email'],
        'Submitted: ' . date('d M Y, H:i', strtotime($booking['created_at'])),
        '',
        'REPAIR DETAILS',
        'Device: ' . $booking['laptop_brand'] . ($booking['laptop_model'] ? ' ' . $booking['laptop_model'] : ''),
        'Repair type: ' . ucfirst($booking['repair_category']),
        'Preferred date: ' . date('d M Y', strtotime($booking['repair_date'])),
        'Service: ' . ucfirst($booking['service_option']),
        'Time slot: ' . ($booking['time_slot'] ?: 'Not specified'),
        '',
        'Issue reported:',
        $booking['issue_description'] ?: 'Not provided',
    ];
    if (!empty($booking['collection_address'])) $pdf_lines[] = 'Collection address: ' . $booking['collection_address'];
    if (!empty($booking['staff_note'])) $pdf_lines[] = 'Technician note: ' . $booking['staff_note'];
    $pdf_lines[] = '';
    $pdf_lines[] = 'Keep this receipt as proof of your repair booking.';

    $escape_pdf = static function (string $value): string {
        return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], preg_replace('/[^\x20-\x7E]/', '?', $value));
    };
    $content = "BT\n/F1 16 Tf\n50 760 Td\n(" . $escape_pdf('Quickfix Tech Solutions') . ") Tj\n/F2 12 Tf\n0 -24 Td\n";
    foreach ($pdf_lines as $index => $line) {
        if ($index > 0) $content .= "0 -18 Td\n";
        $content .= '(' . $escape_pdf($line) . ") Tj\n";
    }
    $content .= "ET\n";
    $objects = [
        '<< /Type /Catalog /Pages 2 0 R >>',
        '<< /Type /Pages /Kids [3 0 R] /Count 1 >>',
        '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Resources << /Font << /F1 4 0 R /F2 6 0 R >> >> /Contents 5 0 R >>',
        '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica-Bold >>',
        '<< /Length ' . strlen($content) . " >>\nstream\n" . $content . "endstream",
        '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>',
    ];
    $pdf = "%PDF-1.4\n";
    $offsets = [0];
    foreach ($objects as $number => $object) {
        $offsets[] = strlen($pdf);
        $pdf .= ($number + 1) . " 0 obj\n" . $object . "\nendobj\n";
    }
    $xref = strlen($pdf);
    $pdf .= "xref\n0 7\n0000000000 65535 f \n";
    for ($number = 1; $number <= 6; $number++) $pdf .= sprintf("%010d 00000 n \n", $offsets[$number]);
    $pdf .= "trailer\n<< /Size 7 /Root 1 0 R >>\nstartxref\n" . $xref . "\n%%EOF";
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="repair-receipt-' . $booking['reference_number'] . '.pdf"');
    echo $pdf;
    exit();
}

function receipt_escape(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repair Booking Receipt - <?= receipt_escape($booking['reference_number']) ?></title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; padding: 32px; font-family: Arial, sans-serif; color: #172033; background: #eef1f7; }
        .receipt { max-width: 760px; margin: 0 auto; padding: 42px; background: #fff; border: 1px solid #d8deea; }
        .header { display: flex; justify-content: space-between; gap: 24px; padding-bottom: 26px; border-bottom: 3px solid #4f46e5; }
        h1 { margin: 0 0 8px; font-size: 25px; color: #4f46e5; }
        .subtitle, .muted { color: #64748b; font-size: 13px; }
        .reference { text-align: right; }
        .reference strong { display: block; margin-top: 6px; font-size: 21px; letter-spacing: 1px; }
        h2 { margin: 28px 0 12px; font-size: 15px; color: #334155; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px; }
        .details { display: grid; grid-template-columns: 1fr 1fr; gap: 12px 28px; }
        .detail label { display: block; margin-bottom: 3px; color: #64748b; font-size: 11px; text-transform: uppercase; }
        .detail div { font-size: 14px; }
        .status { display: inline-block; padding: 5px 10px; color: #166534; background: #dcfce7; border-radius: 4px; font-weight: bold; }
        .issue { white-space: pre-wrap; line-height: 1.5; font-size: 14px; }
        .footer { margin-top: 30px; padding-top: 18px; border-top: 1px solid #e2e8f0; font-size: 12px; color: #64748b; }
        .actions { max-width: 760px; margin: 18px auto 0; text-align: right; }
        .actions a, button { display: inline-block; padding: 11px 16px; border: 0; border-radius: 5px; color: #fff; background: #4f46e5; font-weight: bold; cursor: pointer; text-decoration: none; }
        .actions a { background: #0f766e; margin-right: 8px; }
        @media (max-width: 560px) { body { padding: 12px; } .receipt { padding: 24px 18px; } .header { display: block; } .reference { margin-top: 18px; text-align: left; } .details { grid-template-columns: 1fr; } }
        @media print { body { padding: 0; background: #fff; } .receipt { max-width: none; border: 0; } .actions { display: none; } }
    </style>
</head>
<body>
    <main class="receipt">
        <header class="header">
            <div>
                <h1>Quickfix Tech Solutions</h1>
                <div class="subtitle">Laptop repair booking receipt</div>
            </div>
            <div class="reference">
                <div class="muted">Reference number</div>
                <strong><?= receipt_escape($booking['reference_number']) ?></strong>
            </div>
        </header>

        <h2>Booking status</h2>
        <div class="status"><?= receipt_escape($booking['status']) ?></div>

        <h2>Customer</h2>
        <div class="details">
            <div class="detail"><label>Name</label><div><?= receipt_escape($booking['full_name']) ?></div></div>
            <div class="detail"><label>Phone</label><div><?= receipt_escape($booking['phone']) ?></div></div>
            <div class="detail"><label>Email</label><div><?= receipt_escape($booking['email']) ?></div></div>
            <div class="detail"><label>Submitted</label><div><?= date('d M Y, H:i', strtotime($booking['created_at'])) ?></div></div>
        </div>

        <h2>Repair details</h2>
        <div class="details">
            <div class="detail"><label>Device</label><div><?= receipt_escape($booking['laptop_brand'] . ($booking['laptop_model'] ? ' ' . $booking['laptop_model'] : '')) ?></div></div>
            <div class="detail"><label>Repair type</label><div><?= receipt_escape(ucfirst($booking['repair_category'])) ?></div></div>
            <div class="detail"><label>Preferred date</label><div><?= receipt_escape(date('d M Y', strtotime($booking['repair_date']))) ?></div></div>
            <div class="detail"><label>Service</label><div><?= receipt_escape(ucfirst($booking['service_option'])) ?></div></div>
            <?php if (!empty($booking['time_slot'])): ?><div class="detail"><label>Time slot</label><div><?= receipt_escape($booking['time_slot']) ?></div></div><?php endif; ?>
            <?php if ($booking['service_option'] === 'collection' && !empty($booking['collection_address'])): ?><div class="detail"><label>Collection address</label><div><?= receipt_escape($booking['collection_address']) ?></div></div><?php endif; ?>
        </div>

        <h2>Issue reported</h2>
        <div class="issue"><?= receipt_escape($booking['issue_description']) ?></div>
        <?php if (!empty($booking['staff_note'])): ?><h2>Technician note</h2><div class="issue"><?= receipt_escape($booking['staff_note']) ?></div><?php endif; ?>

        <div class="footer">Keep this receipt as proof of your repair booking. Please quote the reference number when contacting Quickfix Tech Solutions.</div>
    </main>
    <div class="actions">
        <a href="repair-receipt.php?ref=<?= urlencode($booking['reference_number']) ?>&format=pdf">Download PDF</a>
        <button type="button" onclick="window.print()">Print Receipt</button>
    </div>
</body>
</html>
