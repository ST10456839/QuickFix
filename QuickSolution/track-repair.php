<?php
// ─────────────────────────────────────────────
//  Quickfix Tech Solutions – Track Repair Page (Customer)
// ─────────────────────────────────────────────

$host     = "localhost";
$db_name  = "quicksolution";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $db_name);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$booking   = null;
$error_msg = "";

// Handle lookup
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ref   = $conn->real_escape_string(trim($_POST['reference_number'] ?? ''));
    $email = $conn->real_escape_string(trim($_POST['email'] ?? ''));

    if (empty($ref) || empty($email)) {
        $error_msg = "Please enter both your reference number and email address.";
    } else {
        $sql    = "SELECT * FROM bookings WHERE reference_number = '$ref' AND email = '$email' LIMIT 1";
        $result = $conn->query($sql);
        if ($result && $result->num_rows === 1) {
            $booking = $result->fetch_assoc();
        } else {
            $error_msg = "No booking found. Please check your reference number and email address.";
        }
    }
}

// Status steps and colours
$all_statuses = ['Pending', 'Confirmed', 'In Progress', 'Ready for Pickup', 'Completed', 'Cancelled'];

$status_meta = [
    'Pending'          => ['icon' => 'fa-clock',          'color' => '#f59e0b', 'desc' => 'Your request has been received and is awaiting confirmation.'],
    'Confirmed'        => ['icon' => 'fa-check-circle',   'color' => '#3b82f6', 'desc' => 'We\'ve confirmed your booking. Please bring in your laptop or await collection.'],
    'In Progress'      => ['icon' => 'fa-tools',          'color' => '#8b5cf6', 'desc' => 'Our technicians are currently working on your device.'],
    'Ready for Pickup' => ['icon' => 'fa-box-open',       'color' => '#10b981', 'desc' => 'Your repair is complete! Your laptop is ready for collection at our workshop.'],
    'Completed'        => ['icon' => 'fa-star',           'color' => '#4f46e5', 'desc' => 'Repair completed and device collected. Thank you for choosing QuickFix!'],
    'Cancelled'        => ['icon' => 'fa-times-circle',   'color' => '#ef4444', 'desc' => 'This booking has been cancelled. Please contact us if this was a mistake.'],
];

// Progress percentage per status
$progress_map = [
    'Pending'          => 10,
    'Confirmed'        => 30,
    'In Progress'      => 60,
    'Ready for Pickup' => 85,
    'Completed'        => 100,
    'Cancelled'        => 0,
];

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Your Repair – Quickfix Tech Solutions</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <style>
        :root {
            --primary: #4f46e5;
            --secondary: #8b5cf6;
            --dark: #0f172a;
            --darker: #020617;
            --text: #e2e8f0;
            --text-gray: #94a3b8;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --card-bg: #1e293b;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; color: var(--text); background: var(--darker); overflow-x: hidden; }
        a { text-decoration: none; color: inherit; }

        .container { width: 90%; max-width: 1100px; margin: 0 auto; padding: 0 15px; }

        /* Header */
        header {
            background: rgba(15,23,42,0.95);
            backdrop-filter: blur(10px);
            position: fixed; top: 0; left: 0; right: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }
        .header-container { display: flex; justify-content: space-between; align-items: center; padding: 15px 0; }
        .logo { font-size: 22px; font-weight: 700; color: var(--primary); display: flex; align-items: center; gap: 10px; }
        .logo span { color: var(--secondary); }
        nav { display: flex; gap: 28px; align-items: center; }
        nav a { font-weight: 500; font-size: 14px; transition: color 0.3s; position: relative; padding: 5px 0; }
        nav a:hover { color: var(--primary); }
        nav a::after { content: ''; position: absolute; bottom: 0; left: 0; width: 0; height: 2px; background: var(--primary); transition: width 0.3s; }
        nav a:hover::after { width: 100%; }
        .nav-cta { background: linear-gradient(to right, var(--primary), var(--secondary)); color: white !important; padding: 8px 18px; border-radius: 30px; font-weight: 600; }
        .nav-cta::after { display: none !important; }
        .mobile-toggle { display: none; flex-direction: column; gap: 5px; cursor: pointer; }
        .mobile-toggle span { height: 3px; width: 26px; background: var(--text); border-radius: 3px; transition: all 0.3s; }

        /* Hero */
        .hero {
            padding: 150px 0 70px;
            background: radial-gradient(circle at top right, rgba(79,70,229,0.2) 0%, transparent 40%),
                        radial-gradient(circle at bottom left, rgba(139,92,246,0.2) 0%, transparent 40%),
                        var(--darker);
            border-bottom: 1px solid rgba(79,70,229,0.2);
            text-align: center;
        }
        .hero-badge { display: inline-flex; align-items: center; gap: 8px; background: rgba(79,70,229,0.15); color: var(--primary); padding: 7px 14px; border-radius: 20px; font-size: 13px; font-weight: 500; border: 1px solid rgba(79,70,229,0.3); margin-bottom: 18px; }
        .hero h1 { font-size: 44px; font-weight: 700; background: linear-gradient(to right, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 12px; }
        .hero p { color: var(--text-gray); font-size: 16px; max-width: 500px; margin: 0 auto; }

        /* Main section */
        .track-section { padding: 70px 0 100px; background: var(--dark); }

        /* Lookup form */
        .lookup-card {
            background: var(--card-bg);
            border: 1px solid rgba(79,70,229,0.2);
            border-radius: 20px;
            padding: 40px;
            max-width: 580px;
            margin: 0 auto 50px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
        }
        .lookup-card h2 { font-size: 20px; font-weight: 600; margin-bottom: 6px; }
        .lookup-card p { color: var(--text-gray); font-size: 14px; margin-bottom: 28px; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 13px; font-weight: 500; color: var(--text-gray); margin-bottom: 7px; }
        .form-control {
            width: 100%; background: rgba(15,23,42,0.6); border: 1px solid rgba(79,70,229,0.25);
            border-radius: 10px; padding: 13px 16px; color: var(--text);
            font-family: 'Poppins', sans-serif; font-size: 14px; outline: none; transition: border-color 0.3s, box-shadow 0.3s;
        }
        .form-control::placeholder { color: rgba(148,163,184,0.5); }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(79,70,229,0.15); }
        .btn-track {
            width: 100%; padding: 14px; background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white; border: none; border-radius: 10px; font-family: 'Poppins', sans-serif;
            font-size: 15px; font-weight: 600; cursor: pointer; display: flex; align-items: center;
            justify-content: center; gap: 8px; transition: all 0.3s; box-shadow: 0 4px 15px rgba(79,70,229,0.4);
        }
        .btn-track:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(79,70,229,0.6); }
        .error-alert {
            background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3);
            border-radius: 10px; padding: 14px 18px; margin-bottom: 20px;
            display: flex; align-items: center; gap: 10px; color: #fca5a5; font-size: 14px;
        }

        /* Result card */
        .result-wrap { max-width: 760px; margin: 0 auto; }

        .result-header {
            background: var(--card-bg); border: 1px solid rgba(79,70,229,0.2);
            border-radius: 20px 20px 0 0; padding: 30px 36px;
            display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;
        }
        .result-ref { font-size: 13px; color: var(--text-gray); }
        .result-ref strong { display: block; font-size: 26px; background: linear-gradient(to right, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; letter-spacing: 1px; }
        .status-badge {
            padding: 8px 20px; border-radius: 30px; font-size: 14px; font-weight: 600;
            display: flex; align-items: center; gap: 8px;
        }

        /* Progress bar */
        .progress-section {
            background: var(--card-bg); border-left: 1px solid rgba(79,70,229,0.2); border-right: 1px solid rgba(79,70,229,0.2);
            padding: 28px 36px;
        }
        .progress-label { font-size: 13px; color: var(--text-gray); margin-bottom: 10px; display: flex; justify-content: space-between; }
        .progress-bar-bg { background: rgba(79,70,229,0.15); border-radius: 10px; height: 10px; overflow: hidden; }
        .progress-bar-fill { height: 100%; border-radius: 10px; background: linear-gradient(to right, var(--primary), var(--secondary)); transition: width 1.2s ease; }

        /* Timeline steps */
        .timeline-section {
            background: var(--card-bg); border-left: 1px solid rgba(79,70,229,0.2); border-right: 1px solid rgba(79,70,229,0.2);
            padding: 28px 36px 0;
        }
        .timeline { position: relative; padding-left: 28px; }
        .timeline::before { content: ''; position: absolute; left: 10px; top: 8px; bottom: 8px; width: 2px; background: rgba(79,70,229,0.2); }
        .tl-item { position: relative; margin-bottom: 28px; }
        .tl-dot {
            position: absolute; left: -28px; top: 4px;
            width: 22px; height: 22px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 9px; border: 2px solid;
            background: var(--card-bg);
            transition: all 0.3s;
        }
        .tl-dot.done { color: white; border-color: transparent; }
        .tl-dot.active { border-color: var(--primary); color: var(--primary); box-shadow: 0 0 0 4px rgba(79,70,229,0.2); }
        .tl-dot.waiting { border-color: rgba(79,70,229,0.2); color: rgba(79,70,229,0.3); }
        .tl-title { font-size: 14px; font-weight: 600; margin-bottom: 3px; }
        .tl-desc { font-size: 13px; color: var(--text-gray); }

        /* Booking details */
        .details-section {
            background: var(--card-bg); border: 1px solid rgba(79,70,229,0.2);
            border-radius: 0 0 20px 20px; padding: 28px 36px;
        }
        .details-section h3 { font-size: 15px; font-weight: 600; margin-bottom: 18px; display: flex; align-items: center; gap: 8px; }
        .details-section h3 i { color: var(--primary); }
        .details-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .detail-item label { font-size: 12px; color: var(--text-gray); display: block; margin-bottom: 3px; }
        .detail-item span { font-size: 14px; font-weight: 500; }
        .detail-item.full { grid-column: 1 / -1; }

        /* Staff note box */
        .staff-note {
            background: rgba(79,70,229,0.08); border: 1px solid rgba(79,70,229,0.2);
            border-radius: 10px; padding: 14px 18px; margin-top: 18px;
            font-size: 13px; color: var(--text-gray);
        }
        .staff-note strong { color: var(--primary); display: block; margin-bottom: 4px; }
        .btn-download {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            margin-top: 24px; padding: 12px 18px; border-radius: 10px;
            color: white; background: linear-gradient(to right, var(--primary), var(--secondary));
            font-size: 14px; font-weight: 600; transition: transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 4px 15px rgba(79,70,229,0.35);
        }
        .btn-download:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(79,70,229,0.5); }

        /* Footer */
        footer { background: var(--darker); border-top: 1px solid rgba(79,70,229,0.15); padding: 30px 0; text-align: center; color: var(--text-gray); font-size: 13px; }

        @media(max-width:768px) {
            nav { display: none; position: absolute; top: 60px; left: 0; right: 0; background: rgba(15,23,42,0.98); flex-direction: column; padding: 20px; }
            nav.active { display: flex; }
            .mobile-toggle { display: flex; }
            .hero h1 { font-size: 28px; }
            .result-header { flex-direction: column; }
            .details-grid { grid-template-columns: 1fr; }
            .progress-section, .timeline-section, .details-section, .result-header { padding-left: 20px; padding-right: 20px; }
        }
    </style>
</head>
<body>

<header id="header">
    <div class="container">
        <div class="header-container">
            <a href="home.php" class="logo"><i class="fas fa-laptop-medical"></i>Quickfix<span> Tech Solutions</span></a>
            <nav id="nav">
                <a href="home.php">Home</a>
                <a href="home.php#services">Services</a>
                <a href="prices.php">Pricing</a>
                <a href="bookings.php">Book Repair</a>
                <a href="track-repair.php" class="nav-cta">Track Repair</a>
                <a href="home.php#contact">Contact</a>
            </nav>
            <div class="mobile-toggle" id="mobile-toggle"><span></span><span></span><span></span></div>
        </div>
    </div>
</header>

<section class="hero">
    <div class="container">
        <div class="hero-badge"><i class="fas fa-search"></i> Live Tracking</div>
        <h1>Track Your Repair</h1>
        <p>Enter your reference number and email to see a live update of your repair status.</p>
    </div>
</section>

<section class="track-section">
    <div class="container">

        <!-- Lookup Form -->
        <div class="lookup-card" data-aos="fade-up">
            <h2><i class="fas fa-search" style="color:var(--primary);margin-right:8px;"></i>Find Your Booking</h2>
            <p>Use the reference number from your confirmation email (e.g. QF-A3F9C2)</p>

            <?php if (!empty($error_msg)): ?>
            <div class="error-alert"><i class="fas fa-exclamation-circle"></i><?= htmlspecialchars($error_msg) ?></div>
            <?php endif; ?>

            <form method="post" action="track-repair.php">
                <div class="form-group">
                    <label>Reference Number</label>
                    <input type="text" class="form-control" name="reference_number" placeholder="e.g. QF-A3F9C2"
                           value="<?= htmlspecialchars($_POST['reference_number'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" class="form-control" name="email" placeholder="you@email.com"
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                </div>
                <button type="submit" class="btn-track"><i class="fas fa-search"></i> Track My Repair</button>
            </form>
        </div>

        <?php if ($booking): 
            $current_status = $booking['status'];
            $meta           = $status_meta[$current_status] ?? $status_meta['Pending'];
            $progress       = $progress_map[$current_status] ?? 10;
            $is_cancelled   = $current_status === 'Cancelled';

            // Determine which steps are done/active/waiting
            $step_order = ['Pending','Confirmed','In Progress','Ready for Pickup','Completed'];
            $current_idx = array_search($current_status, $step_order);
        ?>

        <div class="result-wrap" data-aos="fade-up">

            <!-- Header -->
            <div class="result-header">
                <div class="result-ref">
                    Booking Reference
                    <strong><?= htmlspecialchars($booking['reference_number']) ?></strong>
                </div>
                <div class="status-badge" style="background:<?= $meta['color'] ?>22;color:<?= $meta['color'] ?>;border:1px solid <?= $meta['color'] ?>44;">
                    <i class="fas <?= $meta['icon'] ?>"></i>
                    <?= htmlspecialchars($current_status) ?>
                </div>
                <a class="btn-download" href="repair-receipt.php?ref=<?= urlencode($booking['reference_number']) ?>&format=pdf" download>
                    <i class="fas fa-file-download"></i> Download Repair Document
                </a>
            </div>

            <!-- Progress bar -->
            <?php if (!$is_cancelled): ?>
            <div class="progress-section">
                <div class="progress-label">
                    <span>Repair Progress</span>
                    <span><?= $progress ?>%</span>
                </div>
                <div class="progress-bar-bg">
                    <div class="progress-bar-fill" id="prog-bar" style="width:0%"></div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="timeline-section">
                <div class="timeline">
                    <?php foreach ($step_order as $i => $step):
                        if ($current_idx === false) {
                            $state = 'waiting';
                        } elseif ($i < $current_idx) {
                            $state = 'done';
                        } elseif ($i === $current_idx) {
                            $state = 'active';
                        } else {
                            $state = 'waiting';
                        }
                        $s_meta  = $status_meta[$step];
                        $bg_done = "background:linear-gradient(to right,var(--primary),var(--secondary));border-color:transparent;";
                    ?>
                    <div class="tl-item">
                        <div class="tl-dot <?= $state ?>" <?= $state === 'done' ? "style=\"$bg_done\"" : "" ?>>
                            <i class="fas <?= $state === 'done' ? 'fa-check' : $s_meta['icon'] ?>"></i>
                        </div>
                        <div class="tl-title" style="color:<?= $state === 'waiting' ? 'var(--text-gray)' : 'var(--text)' ?>">
                            <?= $step ?>
                        </div>
                        <?php if ($state === 'active'): ?>
                        <div class="tl-desc"><?= $s_meta['desc'] ?></div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php else: ?>
            <div class="progress-section" style="border-bottom:1px solid rgba(239,68,68,0.2);">
                <div class="error-alert" style="margin:0;"><i class="fas fa-times-circle"></i><?= $meta['desc'] ?></div>
            </div>
            <?php endif; ?>

            <!-- Booking Details -->
            <div class="details-section">
                <h3><i class="fas fa-clipboard-list"></i> Booking Details</h3>
                <div class="details-grid">
                    <div class="detail-item">
                        <label>Customer Name</label>
                        <span><?= htmlspecialchars($booking['full_name']) ?></span>
                    </div>
                    <div class="detail-item">
                        <label>Phone</label>
                        <span><?= htmlspecialchars($booking['phone']) ?></span>
                    </div>
                    <div class="detail-item">
                        <label>Laptop Brand</label>
                        <span><?= htmlspecialchars($booking['laptop_brand']) ?></span>
                    </div>
                    <div class="detail-item">
                        <label>Laptop Model</label>
                        <span><?= htmlspecialchars($booking['laptop_model'] ?: '—') ?></span>
                    </div>
                    <div class="detail-item">
                        <label>Repair Category</label>
                        <span><?= htmlspecialchars(ucfirst($booking['repair_category'])) ?></span>
                    </div>
                    <div class="detail-item">
                        <label>Preferred Date</label>
                        <span><?= date('d M Y', strtotime($booking['repair_date'])) ?></span>
                    </div>
                    <div class="detail-item">
                        <label>Service Option</label>
                        <span><?= ucfirst(htmlspecialchars($booking['service_option'])) ?></span>
                    </div>
                    <div class="detail-item">
                        <label>Booked On</label>
                        <span><?= date('d M Y, H:i', strtotime($booking['created_at'])) ?></span>
                    </div>
                    <div class="detail-item full">
                        <label>Issue Description</label>
                        <span><?= htmlspecialchars($booking['issue_description']) ?></span>
                    </div>
                    <?php if (!empty($booking['staff_note'])): ?>
                    <div class="detail-item full">
                        <div class="staff-note">
                            <strong><i class="fas fa-comment-dots"></i> Note from our technician</strong>
                            <?= htmlspecialchars($booking['staff_note']) ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

        </div><!-- /result-wrap -->

        <script>
        // Animate progress bar after load
        window.addEventListener('load', function() {
            setTimeout(function() {
                document.getElementById('prog-bar').style.width = '<?= $progress ?>%';
            }, 400);
        });
        </script>

        <?php endif; ?>

    </div>
</section>

<footer>
    <div class="container">
        <p>© 2025 Quickfix Tech Solutions · Hatfield, Pretoria · <a href="tel:+27123456789" style="color:var(--primary);">012 345 6789</a></p>
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
AOS.init({ duration: 800, once: true });
window.addEventListener('scroll', () => {
    document.getElementById('header').style.boxShadow = window.scrollY > 50 ? '0 5px 20px rgba(0,0,0,0.4)' : '';
});
const toggle = document.getElementById('mobile-toggle');
const nav    = document.getElementById('nav');
toggle.addEventListener('click', () => { toggle.classList.toggle('active'); nav.classList.toggle('active'); });
</script>
</body>
</html>
