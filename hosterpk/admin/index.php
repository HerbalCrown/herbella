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
$sql = 'SELECT * FROM orders' . ($where ? ' WHERE ' . implode(' AND ', $where) : '') . ' ORDER BY created_at DESC LIMIT 250';
$stmt = db()->prepare($sql);
$stmt->execute($params);
$orders = $stmt->fetchAll();
$stats = db()->query("SELECT COUNT(*) total, SUM(order_status='pending') pending, SUM(order_status='confirmed') confirmed, SUM(order_status='shipped') shipped, SUM(order_status='delivered') delivered FROM orders")->fetch();
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Orders — Herbal Crown</title><link rel="stylesheet" href="../assets/css/admin.min.css"></head>
<body class="admin-page"><header><a href="../index.php"><img src="../assets/images/crown-mark.svg" alt=""> HERBAL CROWN</a><span><?= e((string)$_SESSION['admin_name']) ?> · <a href="logout.php">Sign out</a></span></header>
<main><div class="admin-title"><div><p>ORDER MANAGEMENT</p><h1>Herbella orders</h1></div><a class="export" href="export.php?status=<?= e($status) ?>&q=<?= e($search) ?>">Export CSV</a></div>
<section class="metric-grid"><article><span>Total</span><strong><?= (int)$stats['total'] ?></strong></article><article><span>Pending</span><strong><?= (int)$stats['pending'] ?></strong></article><article><span>Confirmed</span><strong><?= (int)$stats['confirmed'] ?></strong></article><article><span>Shipped</span><strong><?= (int)$stats['shipped'] ?></strong></article><article><span>Delivered</span><strong><?= (int)$stats['delivered'] ?></strong></article></section>
<form class="filters" method="get"><input name="q" value="<?= e($search) ?>" placeholder="Search order, customer, phone or city"><select name="status"><option value="">All statuses</option><?php foreach (status_options() as $option): ?><option value="<?= e($option) ?>" <?= $status === $option ? 'selected' : '' ?>><?= e(ucfirst($option)) ?></option><?php endforeach; ?></select><button>Filter</button></form>
<div class="table-wrap"><table><thead><tr><th>Order</th><th>Customer</th><th>Package</th><th>Total</th><th>Status</th><th>Placed</th><th></th></tr></thead><tbody>
<?php foreach ($orders as $order): ?><tr><td><strong><?= e($order['order_number']) ?></strong></td><td><?= e($order['customer_name']) ?><small><?= e($order['phone']) ?> · <?= e($order['city']) ?></small></td><td><?= e($order['bundle_name']) ?> × <?= (int)$order['quantity'] ?></td><td><?= money((int)$order['total']) ?></td><td><span class="status <?= e($order['order_status']) ?>"><?= e($order['order_status']) ?></span></td><td><?= e(date('d M Y, H:i', strtotime($order['created_at']))) ?></td><td><a href="order.php?id=<?= (int)$order['id'] ?>">View →</a></td></tr><?php endforeach; ?>
<?php if (!$orders): ?><tr><td colspan="7" class="empty">No orders found.</td></tr><?php endif; ?></tbody></table></div>
</main></body></html>
