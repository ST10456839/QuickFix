<?php
// ─────────────────────────────────────────────
//  Quickfix Tech Solutions – Booking Confirmation Page
// ─────────────────────────────────────────────
session_start();

// Guard — only accessible after a successful booking
if (empty($_SESSION['booking_success'])) {
    header("Location: bookings.html");
    exit();
}

$reference_number = $_SESSION['reference_number'] ?? 'QF-XXXXXX';
$customer_name    = $_SESSION['customer_name']    ?? 'Customer';

// Clear session after reading
unset($_SESSION['booking_success'], $_SESSION['reference_number'], $_SESSION['customer_name']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmed – Quickfix Tech Solutions</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --secondary: #8b5cf6;
            --dark: #0f172a;
            --darker: #020617;
            --text: #e2e8f0;
            --text-gray: #94a3b8;
            --success: #10b981;
            --card-bg: #1e293b;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--darker);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
            background:
                radial-gradient(circle at top right, rgba(79,70,229,0.15) 0%, transparent 50%),
                radial-gradient(circle at bottom left, rgba(139,92,246,0.15) 0%, transparent 50%),
                var(--darker);
        }
        .confirm-card {
            background: var(--card-bg);
            border: 1px solid rgba(79,70,229,0.25);
            border-radius: 24px;
            padding: 56px 48px;
            text-align: center;
            max-width: 520px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        }
        .icon-wrap {
            width: 90px; height: 90px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 28px;
            font-size: 36px; color: white;
            box-shadow: 0 8px 30px rgba(79,70,229,0.5);
            animation: pop 0.5s ease;
        }
        @keyframes pop {
            0% { transform: scale(0.5); opacity: 0; }
            80% { transform: scale(1.1); }
            100% { transform: scale(1); opacity: 1; }
        }
        h1 { font-size: 28px; margin-bottom: 12px; }
        .subtitle { color: var(--text-gray); margin-bottom: 32px; font-size: 15px; }
        .ref-box {
            background: rgba(79,70,229,0.1);
            border: 1px solid rgba(79,70,229,0.25);
            border-radius: 14px;
            padding: 20px 28px;
            margin-bottom: 32px;
        }
        .ref-box p { font-size: 13px; color: var(--text-gray); margin-bottom: 6px; }
        .ref-box strong {
            font-size: 28px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 2px;
        }
        .info-list { text-align: left; margin-bottom: 36px; }
        .info-list li {
            list-style: none;
            display: flex; align-items: flex-start; gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid rgba(79,70,229,0.1);
            font-size: 14px;
            color: var(--text-gray);
        }
        .info-list li:last-child { border: none; }
        .info-list li i { color: var(--primary); margin-top: 2px; width: 16px; flex-shrink: 0; }
        .btn-home {
            display: inline-flex; align-items: center; gap: 8px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            padding: 14px 36px;
            border-radius: 10px;
            font-family: 'Poppins', sans-serif;
            font-size: 15px; font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(79,70,229,0.4);
        }
        .btn-home:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(79,70,229,0.6); }
        .btn-receipt {
            display: inline-flex; align-items: center; gap: 8px;
            margin: 0 0 14px; padding: 12px 24px;
            border: 1px solid rgba(79,70,229,0.35); border-radius: 10px;
            color: var(--text); background: rgba(79,70,229,0.12);
            font-size: 14px; font-weight: 600; text-decoration: none;
        }
        .btn-receipt:hover { background: rgba(79,70,229,0.22); }
        @media (max-width: 480px) {
            .confirm-card { padding: 36px 24px; }
            h1 { font-size: 22px; }
        }
    </style>
</head>
<body>
    <div class="confirm-card">
        <div class="icon-wrap"><i class="fas fa-check"></i></div>
        <h1>Booking Submitted!</h1>
        <p class="subtitle">
            Thank you, <strong><?= htmlspecialchars($customer_name) ?></strong>! 
            Your repair request has been saved. We'll confirm within <strong>30 minutes</strong> via WhatsApp.
        </p>

        <div class="ref-box">
            <p>Your Reference Number</p>
            <strong><?= htmlspecialchars($reference_number) ?></strong>
        </div>

        <ul class="info-list">
            <li>
                <i class="fas fa-file-download"></i>
                Download your PDF receipt below for your records.
            </li>
            <li>
                <i class="fas fa-tools"></i>
                Bring your laptop to our Hatfield workshop or wait for our collection driver.
            </li>
            <li>
                <i class="fas fa-clock"></i>
                Most repairs are completed within <strong>24 hours</strong>.
            </li>
            <li>
                <i class="fas fa-shield-alt"></i>
                No Fix, No Fee — you only pay when your laptop is repaired.
            </li>
        </ul>

        <a href="repair-receipt.php?ref=<?= urlencode($reference_number) ?>" class="btn-receipt" target="_blank" rel="noopener">
            <i class="fas fa-file-pdf"></i> Download PDF Receipt
        </a><br>
        <a href="index.html" class="btn-home">
            <i class="fas fa-home"></i> Back to Home
        </a>
    </div>
</body>
</html>
