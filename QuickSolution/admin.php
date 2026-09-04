<?php
// ─────────────────────────────────────────────
//  Quickfix Tech Solutions – Staff Admin Dashboard
//  Access: admin.php  (password protected)
// ─────────────────────────────────────────────

session_start();

// ── Admin credentials (change these!) ─────────
define('ADMIN_USER', 'admin');
define('ADMIN_PASS', 'quickfix2025');   // ← Change this password

// ── DB Config ─────────────────────────────────
$host     = "localhost";
$db_name  = "quicksolution";
$db_user  = "root";
$db_pass  = "";

// ── Login / Logout ─────────────────────────────
if (isset($_POST['login'])) {
    if ($_POST['admin_user'] === ADMIN_USER && $_POST['admin_pass'] === ADMIN_PASS) {
        $_SESSION['qf_admin'] = true;
    } else {
        $login_error = "Incorrect username or password.";
    }
}
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit();
}

$logged_in = !empty($_SESSION['qf_admin']);

// ── Connect DB (only when logged in) ──────────
if ($logged_in) {
    $conn = new mysqli($host, $db_user, $db_pass, $db_name);
    if ($conn->connect_error) die("DB Error: " . $conn->connect_error);

    // ── Handle status update ───────────────────
    if (isset($_POST['update_status'])) {
        $id         = (int)$_POST['booking_id'];
        $new_status = $conn->real_escape_string($_POST['new_status']);
        $staff_note = $conn->real_escape_string(trim($_POST['staff_note'] ?? ''));
        if (!$conn->query("UPDATE bookings SET status='$new_status', staff_note='$staff_note', updated_at=NOW() WHERE id=$id")) {
            die("Status update failed: " . $conn->error);
        }
        header("Location: admin.php?updated=1");
        exit();
    }

    // ── Handle delete ─────────────────────────
    if (isset($_GET['delete'])) {
        $id = (int)$_GET['delete'];
        $conn->query("DELETE FROM bookings WHERE id=$id");
        header("Location: admin.php?deleted=1");
        exit();
    }

    // ── Filters ───────────────────────────────
    $filter_status   = $conn->real_escape_string($_GET['status'] ?? '');
    $filter_search   = $conn->real_escape_string(trim($_GET['search'] ?? ''));
    $filter_date     = $conn->real_escape_string($_GET['date'] ?? '');
    $sort            = in_array($_GET['sort'] ?? '', ['asc','desc']) ? $_GET['sort'] : 'desc';

    $where = "WHERE 1=1";
    if ($filter_status) $where .= " AND status='$filter_status'";
    if ($filter_search) $where .= " AND (full_name LIKE '%$filter_search%' OR reference_number LIKE '%$filter_search%' OR email LIKE '%$filter_search%' OR phone LIKE '%$filter_search%')";
    if ($filter_date)   $where .= " AND repair_date='$filter_date'";

    $bookings_result = $conn->query("SELECT * FROM bookings $where ORDER BY created_at $sort");
    $bookings        = $bookings_result ? $bookings_result->fetch_all(MYSQLI_ASSOC) : [];

    // ── Stats ─────────────────────────────────
    $stats = [];
    $statuses = ['Pending','Confirmed','In Progress','Ready for Pickup','Completed','Cancelled'];
    foreach ($statuses as $s) {
        $r = $conn->query("SELECT COUNT(*) AS cnt FROM bookings WHERE status='$s'");
        $stats[$s] = $r->fetch_assoc()['cnt'];
    }
    $total = (int)$conn->query("SELECT COUNT(*) AS cnt FROM bookings")->fetch_assoc()['cnt'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard – Quickfix Tech Solutions</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            --info: #3b82f6;
            --card-bg: #1e293b;
            --sidebar-w: 260px;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; color: var(--text); background: var(--darker); min-height: 100vh; }
        a { text-decoration: none; color: inherit; }

        /* ── Login Page ── */
        .login-wrap {
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
            background: radial-gradient(circle at top right, rgba(79,70,229,0.2) 0%, transparent 50%),
                        radial-gradient(circle at bottom left, rgba(139,92,246,0.2) 0%, transparent 50%), var(--darker);
        }
        .login-card {
            background: var(--card-bg); border: 1px solid rgba(79,70,229,0.25);
            border-radius: 20px; padding: 48px 44px; width: 400px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        }
        .login-logo { font-size: 22px; font-weight: 700; color: var(--primary); margin-bottom: 6px; display: flex; align-items: center; gap: 10px; }
        .login-logo span { color: var(--secondary); }
        .login-sub { color: var(--text-gray); font-size: 13px; margin-bottom: 30px; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 13px; font-weight: 500; color: var(--text-gray); margin-bottom: 7px; }
        .form-control {
            width: 100%; background: rgba(15,23,42,0.6); border: 1px solid rgba(79,70,229,0.25);
            border-radius: 10px; padding: 12px 14px; color: var(--text); font-family: 'Poppins', sans-serif;
            font-size: 14px; outline: none; transition: border-color 0.3s, box-shadow 0.3s;
        }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(79,70,229,0.15); }
        .btn-login {
            width: 100%; padding: 13px; background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white; border: none; border-radius: 10px; font-family: 'Poppins', sans-serif;
            font-size: 15px; font-weight: 600; cursor: pointer; transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(79,70,229,0.4);
        }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(79,70,229,0.6); }
        .login-error { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); border-radius: 8px; padding: 10px 14px; font-size: 13px; color: #fca5a5; margin-bottom: 16px; }

        /* ── Dashboard Layout ── */
        .dashboard { display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-w); background: var(--dark); border-right: 1px solid rgba(79,70,229,0.15);
            display: flex; flex-direction: column; position: fixed; top: 0; left: 0; height: 100vh; z-index: 100; overflow-y: auto;
        }
        .sidebar-logo { padding: 26px 24px 20px; border-bottom: 1px solid rgba(79,70,229,0.15); }
        .sidebar-logo .logo-text { font-size: 18px; font-weight: 700; color: var(--primary); }
        .sidebar-logo .logo-text span { color: var(--secondary); }
        .sidebar-logo p { font-size: 11px; color: var(--text-gray); margin-top: 3px; }
        .sidebar-nav { padding: 20px 16px; flex: 1; }
        .nav-label { font-size: 10px; font-weight: 600; color: var(--text-gray); text-transform: uppercase; letter-spacing: 1px; margin: 16px 0 8px 8px; }
        .nav-item {
            display: flex; align-items: center; gap: 10px; padding: 10px 14px;
            border-radius: 10px; margin-bottom: 4px; font-size: 14px; font-weight: 500;
            cursor: pointer; transition: all 0.2s; color: var(--text-gray);
        }
        .nav-item:hover, .nav-item.active { background: rgba(79,70,229,0.15); color: var(--primary); }
        .nav-item i { width: 18px; text-align: center; }
        .sidebar-footer { padding: 16px 24px; border-top: 1px solid rgba(79,70,229,0.15); }
        .staff-info { display: flex; align-items: center; gap: 10px; }
        .staff-avatar { width: 36px; height: 36px; background: linear-gradient(to right, var(--primary), var(--secondary)); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700; }
        .staff-name { font-size: 13px; font-weight: 600; }
        .staff-role { font-size: 11px; color: var(--text-gray); }
        .btn-logout { display: flex; align-items: center; gap: 6px; color: var(--danger); font-size: 12px; margin-top: 10px; cursor: pointer; transition: opacity 0.2s; }
        .btn-logout:hover { opacity: 0.8; }

        /* Main */
        .main { margin-left: var(--sidebar-w); flex: 1; padding: 30px; }

        /* Top bar */
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 14px; }
        .page-title { font-size: 22px; font-weight: 700; }
        .page-title span { color: var(--text-gray); font-size: 14px; font-weight: 400; margin-left: 10px; }
        .toast {
            display: none; padding: 10px 18px; border-radius: 8px; font-size: 13px; font-weight: 500;
            align-items: center; gap: 8px;
        }
        .toast.success { display: flex; background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.3); color: var(--success); }

        /* Stat cards */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 16px; margin-bottom: 30px; }
        .stat-card {
            background: var(--card-bg); border: 1px solid rgba(79,70,229,0.15);
            border-radius: 14px; padding: 20px;
        }
        .stat-card .stat-label { font-size: 12px; color: var(--text-gray); margin-bottom: 6px; }
        .stat-card .stat-num { font-size: 28px; font-weight: 700; }
        .stat-card .stat-icon { font-size: 20px; margin-bottom: 8px; }

        /* Filters */
        .filters-bar {
            background: var(--card-bg); border: 1px solid rgba(79,70,229,0.15);
            border-radius: 14px; padding: 18px 22px; margin-bottom: 22px;
            display: flex; flex-wrap: wrap; gap: 12px; align-items: flex-end;
        }
        .filter-group { display: flex; flex-direction: column; gap: 5px; }
        .filter-group label { font-size: 11px; color: var(--text-gray); font-weight: 500; }
        .filter-control {
            background: rgba(15,23,42,0.6); border: 1px solid rgba(79,70,229,0.2);
            border-radius: 8px; padding: 8px 12px; color: var(--text); font-family: 'Poppins', sans-serif; font-size: 13px;
            outline: none; min-width: 160px; transition: border-color 0.3s;
        }
        .filter-control:focus { border-color: var(--primary); }
        .btn-filter {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white; border: none; border-radius: 8px; padding: 9px 18px;
            font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.3s;
        }
        .btn-filter:hover { transform: translateY(-1px); }
        .btn-clear { background: rgba(239,68,68,0.1); color: var(--danger); border: 1px solid rgba(239,68,68,0.2); border-radius: 8px; padding: 8px 14px; font-family: 'Poppins', sans-serif; font-size: 13px; cursor: pointer; }

        /* Table */
        .table-card { background: var(--card-bg); border: 1px solid rgba(79,70,229,0.15); border-radius: 14px; overflow: hidden; }
        .table-header { padding: 18px 22px; border-bottom: 1px solid rgba(79,70,229,0.1); display: flex; justify-content: space-between; align-items: center; }
        .table-header h3 { font-size: 15px; font-weight: 600; }
        .count-badge { background: rgba(79,70,229,0.15); color: var(--primary); border-radius: 20px; padding: 3px 12px; font-size: 12px; font-weight: 600; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th { background: rgba(15,23,42,0.5); padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-gray); border-bottom: 1px solid rgba(79,70,229,0.1); }
        td { padding: 14px 16px; border-bottom: 1px solid rgba(79,70,229,0.07); vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: rgba(79,70,229,0.04); }
        .ref-text { font-weight: 600; color: var(--primary); font-size: 12px; }
        .customer-name { font-weight: 500; }
        .customer-email { font-size: 12px; color: var(--text-gray); }

        /* Status badges */
        .badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; white-space: nowrap;
        }
        .badge-pending       { background: rgba(245,158,11,0.15);  color: #f59e0b; border: 1px solid rgba(245,158,11,0.3); }
        .badge-confirmed     { background: rgba(59,130,246,0.15);  color: #3b82f6; border: 1px solid rgba(59,130,246,0.3); }
        .badge-inprogress    { background: rgba(139,92,246,0.15);  color: #8b5cf6; border: 1px solid rgba(139,92,246,0.3); }
        .badge-ready         { background: rgba(16,185,129,0.15);  color: #10b981; border: 1px solid rgba(16,185,129,0.3); }
        .badge-completed     { background: rgba(79,70,229,0.15);   color: #4f46e5; border: 1px solid rgba(79,70,229,0.3); }
        .badge-cancelled     { background: rgba(239,68,68,0.15);   color: #ef4444; border: 1px solid rgba(239,68,68,0.3); }

        /* Action buttons */
        .btn-action { border: none; border-radius: 7px; padding: 7px 13px; font-size: 12px; font-weight: 600; cursor: pointer; font-family: 'Poppins', sans-serif; transition: all 0.2s; display: inline-flex; align-items: center; gap: 5px; }
        .btn-edit { background: rgba(79,70,229,0.15); color: var(--primary); }
        .btn-edit:hover { background: rgba(79,70,229,0.3); }
        .btn-del  { background: rgba(239,68,68,0.1); color: var(--danger); }
        .btn-del:hover  { background: rgba(239,68,68,0.25); }

        /* Modal */
        .modal-overlay {
            position: fixed; inset: 0; background: rgba(2,6,23,0.85); backdrop-filter: blur(6px);
            z-index: 9999; display: flex; align-items: center; justify-content: center;
            opacity: 0; pointer-events: none; transition: opacity 0.3s;
        }
        .modal-overlay.open { opacity: 1; pointer-events: all; }
        .modal-box {
            background: var(--card-bg); border: 1px solid rgba(79,70,229,0.3); border-radius: 20px;
            padding: 36px; width: 520px; max-width: 94vw;
            transform: scale(0.92); transition: transform 0.3s;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        }
        .modal-overlay.open .modal-box { transform: scale(1); }
        .modal-title { font-size: 18px; font-weight: 700; margin-bottom: 6px; }
        .modal-ref   { font-size: 13px; color: var(--text-gray); margin-bottom: 24px; }
        .modal-group { margin-bottom: 18px; }
        .modal-group label { display: block; font-size: 12px; font-weight: 500; color: var(--text-gray); margin-bottom: 6px; }
        .modal-actions { display: flex; gap: 12px; margin-top: 24px; }
        .btn-save { flex: 1; padding: 12px; background: linear-gradient(to right, var(--primary), var(--secondary)); color: white; border: none; border-radius: 10px; font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 600; cursor: pointer; }
        .btn-cancel-modal { flex: 1; padding: 12px; background: rgba(239,68,68,0.1); color: var(--danger); border: 1px solid rgba(239,68,68,0.2); border-radius: 10px; font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 600; cursor: pointer; }

        .empty-state { text-align: center; padding: 60px 20px; color: var(--text-gray); }
        .empty-state i { font-size: 40px; margin-bottom: 14px; display: block; }

        @media(max-width:900px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.3s; }
            .sidebar.open { transform: translateX(0); }
            .main { margin-left: 0; padding: 20px; }
            .mobile-menu-btn { display: flex; }
        }
    </style>
</head>
<body>

<?php if (!$logged_in): ?>
<!-- ── LOGIN PAGE ─────────────────────────────── -->
<div class="login-wrap">
    <div class="login-card">
        <div class="login-logo"><i class="fas fa-laptop-medical"></i>Quickfix<span> Tech Solutions</span></div>
        <p class="login-sub">Staff Admin Portal — authorised personnel only</p>

        <?php if (!empty($login_error)): ?>
        <div class="login-error"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($login_error) ?></div>
        <?php endif; ?>

        <form method="post" action="admin.php">
            <div class="form-group">
                <label>Username</label>
                <input type="text" class="form-control" name="admin_user" placeholder="Enter username" required autofocus>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="admin_pass" placeholder="Enter password" required>
            </div>
            <button type="submit" name="login" class="btn-login"><i class="fas fa-sign-in-alt"></i> Sign In</button>
        </form>
    </div>
</div>

<?php else: ?>
<!-- ── DASHBOARD ──────────────────────────────── -->
<div class="dashboard">

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <div class="logo-text"><i class="fas fa-laptop-medical"></i> Quickfix<span> Tech Solutions</span></div>
            <p>Staff Dashboard</p>
        </div>
        <div class="sidebar-nav">
            <div class="nav-label">Main</div>
            <div class="nav-item active"><i class="fas fa-th-large"></i> All Bookings</div>
            <a href="admin.php?status=Pending"       class="nav-item"><i class="fas fa-clock"></i> Pending <span style="margin-left:auto;background:rgba(245,158,11,0.2);color:#f59e0b;border-radius:10px;padding:1px 8px;font-size:11px;"><?= $stats['Pending'] ?></span></a>
            <a href="admin.php?status=Confirmed"     class="nav-item"><i class="fas fa-check-circle"></i> Confirmed</a>
            <a href="admin.php?status=In+Progress"   class="nav-item"><i class="fas fa-tools"></i> In Progress <span style="margin-left:auto;background:rgba(139,92,246,0.2);color:#8b5cf6;border-radius:10px;padding:1px 8px;font-size:11px;"><?= $stats['In Progress'] ?></span></a>
            <a href="admin.php?status=Ready+for+Pickup" class="nav-item"><i class="fas fa-box-open"></i> Ready for Pickup</a>
            <a href="admin.php?status=Completed"     class="nav-item"><i class="fas fa-star"></i> Completed</a>
            <a href="admin.php?status=Cancelled"     class="nav-item"><i class="fas fa-times-circle"></i> Cancelled</a>
            <div class="nav-label">Links</div>
            <a href="bookings.html" class="nav-item" target="_blank"><i class="fas fa-calendar-plus"></i> New Booking</a>
            <a href="track-repair.php" class="nav-item" target="_blank"><i class="fas fa-search"></i> Track Repair</a>
        </div>
        <div class="sidebar-footer">
            <div class="staff-info">
                <div class="staff-avatar">A</div>
                <div>
                    <div class="staff-name">Administrator</div>
                    <div class="staff-role">Staff · Quickfix Tech Solutions</div>
                </div>
            </div>
            <a href="admin.php?logout=1" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Sign Out</a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main">

        <!-- Top bar -->
        <div class="topbar">
            <div class="page-title">
                All Bookings
                <span><?= date('l, d F Y') ?></span>
            </div>
            <?php if (isset($_GET['updated'])): ?>
            <div class="toast success"><i class="fas fa-check-circle"></i> Booking status updated successfully!</div>
            <?php elseif (isset($_GET['deleted'])): ?>
            <div class="toast success" style="background:rgba(239,68,68,0.1);border-color:rgba(239,68,68,0.3);color:var(--danger);"><i class="fas fa-trash"></i> Booking deleted.</div>
            <?php endif; ?>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="color:var(--primary)"><i class="fas fa-list"></i></div>
                <div class="stat-label">Total Bookings</div>
                <div class="stat-num" style="color:var(--primary)"><?= $total ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="color:#f59e0b"><i class="fas fa-clock"></i></div>
                <div class="stat-label">Pending</div>
                <div class="stat-num" style="color:#f59e0b"><?= $stats['Pending'] ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="color:#8b5cf6"><i class="fas fa-tools"></i></div>
                <div class="stat-label">In Progress</div>
                <div class="stat-num" style="color:#8b5cf6"><?= $stats['In Progress'] ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="color:#10b981"><i class="fas fa-box-open"></i></div>
                <div class="stat-label">Ready</div>
                <div class="stat-num" style="color:#10b981"><?= $stats['Ready for Pickup'] ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="color:#4f46e5"><i class="fas fa-star"></i></div>
                <div class="stat-label">Completed</div>
                <div class="stat-num" style="color:#4f46e5"><?= $stats['Completed'] ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="color:#ef4444"><i class="fas fa-times-circle"></i></div>
                <div class="stat-label">Cancelled</div>
                <div class="stat-num" style="color:#ef4444"><?= $stats['Cancelled'] ?></div>
            </div>
        </div>

        <!-- Filters -->
        <form method="get" action="admin.php">
            <div class="filters-bar">
                <div class="filter-group">
                    <label>Search</label>
                    <input type="text" class="filter-control" name="search" placeholder="Name, ref, email..." value="<?= htmlspecialchars($filter_search) ?>">
                </div>
                <div class="filter-group">
                    <label>Status</label>
                    <select class="filter-control" name="status">
                        <option value="">All Statuses</option>
                        <?php foreach ($statuses as $s): ?>
                        <option value="<?= $s ?>" <?= $filter_status === $s ? 'selected' : '' ?>><?= $s ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Repair Date</label>
                    <input type="date" class="filter-control" name="date" value="<?= htmlspecialchars($filter_date) ?>">
                </div>
                <div class="filter-group">
                    <label>Sort</label>
                    <select class="filter-control" name="sort">
                        <option value="desc" <?= $sort === 'desc' ? 'selected' : '' ?>>Newest First</option>
                        <option value="asc"  <?= $sort === 'asc'  ? 'selected' : '' ?>>Oldest First</option>
                    </select>
                </div>
                <button type="submit" class="btn-filter"><i class="fas fa-filter"></i> Filter</button>
                <a href="admin.php"><button type="button" class="btn-clear"><i class="fas fa-times"></i> Clear</button></a>
            </div>
        </form>

        <!-- Table -->
        <div class="table-card">
            <div class="table-header">
                <h3><i class="fas fa-clipboard-list" style="color:var(--primary);margin-right:8px;"></i>Bookings</h3>
                <span class="count-badge"><?= count($bookings) ?> records</span>
            </div>

            <?php if (empty($bookings)): ?>
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                No bookings found. Try adjusting your filters.
            </div>
            <?php else: ?>
            <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>Ref #</th>
                        <th>Customer</th>
                        <th>Device</th>
                        <th>Category</th>
                        <th>Repair Date</th>
                        <th>Service</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($bookings as $b):
                    $status_key = strtolower(str_replace([' ','_'], '', $b['status']));
                    $badge_map = [
                        'pending'        => 'badge-pending',
                        'confirmed'      => 'badge-confirmed',
                        'inprogress'     => 'badge-inprogress',
                        'readyforpickup' => 'badge-ready',
                        'completed'      => 'badge-completed',
                        'cancelled'      => 'badge-cancelled',
                    ];
                    $badge_class = $badge_map[$status_key] ?? 'badge-pending';
                ?>
                <tr>
                    <td><span class="ref-text"><?= htmlspecialchars($b['reference_number']) ?></span></td>
                    <td>
                        <div class="customer-name"><?= htmlspecialchars($b['full_name']) ?></div>
                        <div class="customer-email"><?= htmlspecialchars($b['email']) ?></div>
                        <div class="customer-email"><?= htmlspecialchars($b['phone']) ?></div>
                    </td>
                    <td>
                        <div><?= htmlspecialchars($b['laptop_brand']) ?></div>
                        <div style="font-size:11px;color:var(--text-gray);"><?= htmlspecialchars($b['laptop_model'] ?: '—') ?></div>
                    </td>
                    <td><?= htmlspecialchars(ucfirst($b['repair_category'])) ?></td>
                    <td><?= date('d M Y', strtotime($b['repair_date'])) ?><br><span style="font-size:11px;color:var(--text-gray);"><?= htmlspecialchars($b['time_slot'] ?: '—') ?></span></td>
                    <td><?= ucfirst(htmlspecialchars($b['service_option'])) ?></td>
                    <td><span class="badge <?= $badge_class ?>"><?= htmlspecialchars($b['status']) ?></span></td>
                    <td>
                        <button class="btn-action btn-edit"
                            onclick="openModal(
                                <?= $b['id'] ?>,
                                '<?= htmlspecialchars(addslashes($b['reference_number'])) ?>',
                                '<?= htmlspecialchars(addslashes($b['full_name'])) ?>',
                                '<?= htmlspecialchars(addslashes($b['status'])) ?>',
                                '<?= htmlspecialchars(addslashes($b['staff_note'] ?? '')) ?>'
                            )">
                            <i class="fas fa-edit"></i> Update
                        </button>
                        <a href="admin.php?delete=<?= $b['id'] ?>" onclick="return confirm('Delete booking <?= htmlspecialchars($b['reference_number']) ?>? This cannot be undone.')">
                            <button class="btn-action btn-del"><i class="fas fa-trash"></i></button>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            </div>
            <?php endif; ?>
        </div>

    </main>
</div>

<!-- ── Update Status Modal ─────────────────── -->
<div class="modal-overlay" id="modal">
    <div class="modal-box">
        <div class="modal-title"><i class="fas fa-edit" style="color:var(--primary);margin-right:8px;"></i>Update Booking</div>
        <div class="modal-ref" id="modal-ref">Ref: –</div>
        <form method="post" action="admin.php">
            <input type="hidden" name="update_status" value="1">
            <input type="hidden" name="booking_id" id="modal-id">

            <div class="modal-group">
                <label>Customer</label>
                <div id="modal-customer" style="font-weight:600;font-size:15px;"></div>
            </div>

            <div class="modal-group">
                <label>New Status</label>
                <select class="form-control" name="new_status" id="modal-status">
                    <option value="Pending">Pending</option>
                    <option value="Confirmed">Confirmed</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Ready for Pickup">Ready for Pickup</option>
                    <option value="Completed">Completed</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
            </div>

            <div class="modal-group">
                <label>Technician Note <span style="color:var(--text-gray);font-weight:400;">(visible to customer)</span></label>
                <textarea class="form-control" name="staff_note" id="modal-note" rows="4"
                    placeholder="e.g. Screen replaced, tested and working. Ready for pickup Tuesday."></textarea>
            </div>

            <div class="modal-actions">
                <button type="submit" class="btn-save"><i class="fas fa-save"></i> Save Changes</button>
                <button type="button" class="btn-cancel-modal" onclick="closeModal()"><i class="fas fa-times"></i> Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(id, ref, name, status, note) {
    document.getElementById('modal-id').value       = id;
    document.getElementById('modal-ref').textContent = 'Ref: ' + ref;
    document.getElementById('modal-customer').textContent = name;
    document.getElementById('modal-note').value     = note;
    const sel = document.getElementById('modal-status');
    for (let i = 0; i < sel.options.length; i++) {
        if (sel.options[i].value === status) { sel.selectedIndex = i; break; }
    }
    document.getElementById('modal').classList.add('open');
}
function closeModal() {
    document.getElementById('modal').classList.remove('open');
}
document.getElementById('modal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>

<?php endif; ?>
</body>
</html>
