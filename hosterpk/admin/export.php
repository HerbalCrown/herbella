<?php
declare(strict_types=1);
require dirname(__DIR__) . '/includes/bootstrap.php';
require_admin();

$status = (string)($_GET['status'] ?? '');
$search = trim((string)($_GET['q'] ?? ''));
$where = [];
$params = [];
if (in_array($status, status_options(), true)) {
    $where[] = 'order_status = ?';
    $params[] = $status;
}
if ($search !== '') {
    $where[] = '(order_number LIKE ? OR customer_name LIKE ? OR phone LIKE ? OR city LIKE ?)';
    $needle = '%' . $search . '%';
    array_push($params, $needle, $needle, $needle, $needle);
}
$stmt = db()->prepare('SELECT * FROM orders' . ($where ? ' WHERE ' . implode(' AND ', $where) : '') . ' ORDER BY created_at DESC');
$stmt->execute($params);

header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="herbella-orders-' . date('Y-m-d') . '.csv"');
echo "\xEF\xBB\xBF";
$output = fopen('php://output', 'wb');
fputcsv($output, ['Order', 'Customer', 'Phone', 'Alternate phone', 'Email', 'Province', 'City', 'Address', 'Package', 'Quantity', 'Total', 'Status', 'Courier', 'Tracking', 'Created']);
while ($order = $stmt->fetch()) {
    fputcsv($output, [$order['order_number'], $order['customer_name'], $order['phone'], $order['alternate_phone'], $order['email'], $order['province'], $order['city'], $order['address'], $order['bundle_name'], $order['quantity'], $order['total'], $order['order_status'], $order['courier'], $order['tracking_number'], $order['created_at']]);
}
fclose($output);
exit;
