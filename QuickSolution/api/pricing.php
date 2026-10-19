<?php
/** GET /api/v1/pricing.php[?category=...] - public, no authentication needed. */
declare(strict_types=1);
require __DIR__ . '/bootstrap.php';

requireMethod('GET');

$category = isset($_GET['category']) ? trim((string) $_GET['category']) : null;

$sql = 'SELECT price_id, category, service_part_name, description, estimated_price
        FROM repair_pricing WHERE is_active = 1';
$params = [];
if ($category !== null && $category !== '') {
    $sql .= ' AND category = :category';
    $params[':category'] = $category;
}
$sql .= ' ORDER BY category, price_id';

$stmt = db()->prepare($sql);
$stmt->execute($params);

ok($stmt->fetchAll());
