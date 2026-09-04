<?php
// ── Database Configuration ──────────────────────────────────────────────────
// Running on XAMPP locally? Leave these as-is.
// On live hosting, update host/username/password/dbname to match your cPanel.


define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'quicksolution');

// ── Create connection ────────────────────────────────────────────────────────
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// ── Check connection ─────────────────────────────────────────────────────────
if ($conn->connect_error) {
    http_response_code(500);
    die(json_encode([
        'success' => false,
        'message' => 'Database connection failed. Please try again later.'
    ]));
}

$conn->set_charset('utf8mb4');
?>
