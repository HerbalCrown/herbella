<?php
declare(strict_types=1);
require dirname(__DIR__) . '/includes/bootstrap.php';
require_admin();

$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
$stmt = db()->prepare('SELECT * FROM orders WHERE id = ?');
$stmt->execute([$id]);
$order = $stmt->fetch();
if (!$order) {
    http_response_code(404);
    exit('Order not found.');
}

$saved = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $status = (string)($_POST['order_status'] ?? '');
    if (!in_array($status, status_options(), true)) {
        http_response_code(422);
        exit('Invalid order status.');
    }
    $courier = mb_substr(trim((string)($_POST['courier'] ?? '')), 0, 100);
    $tracking = mb_substr(trim((string)($_POST['tracking_number'] ?? '')), 0, 100);
    $update = db()->prepare('UPDATE orders SET order_status = ?, courier = ?, tracking_number = ?, updated_at = NOW() WHERE id = ?');
    $update->execute([$status, $courier ?: null, $tracking ?: null, $id]);
    $saved = true;
    $stmt->execute([$id]);
    $order = $stmt->fetch();
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?= e($order['order_number']) ?> — Herbal Crown</title><link rel="stylesheet" href="../assets/css/admin.min.css"></head>
<body class="admin-page"><header><a href="index.php">← All orders</a><span><?= e((string)$_SESSION['admin_name']) ?> · <a href="logout.php">Sign out</a></span></header>
<main class="order-detail"><div class="admin-title"><div><p>ORDER DETAILS</p><h1><?= e($order['order_number']) ?></h1></div><span class="status <?= e($order['order_status']) ?>"><?= e($order['order_status']) ?></span></div>
<?php if ($saved): ?><div class="success">Order updated successfully.</div><?php endif; ?>
<div class="detail-grid"><section><h2>Customer</h2><dl><dt>Name</dt><dd><?= e($order['customer_name']) ?></dd><dt>Phone</dt><dd><?= e($order['phone']) ?></dd><dt>Alternate phone</dt><dd><?= e($order['alternate_phone']) ?: '—' ?></dd><dt>Email</dt><dd><?= e($order['email']) ?: '—' ?></dd><dt>Delivery</dt><dd><?= e($order['address']) ?><br><?= e($order['landmark']) ?><br><?= e($order['city']) ?>, <?= e($order['province']) ?></dd></dl></section>
<section><h2>Order</h2><dl><dt>Package</dt><dd><?= e($order['bundle_name']) ?> × <?= (int)$order['quantity'] ?></dd><dt>Unit price</dt><dd><?= money((int)$order['unit_price']) ?></dd><dt>Shipping</dt><dd><?= money((int)$order['shipping']) ?></dd><dt>Total COD</dt><dd><strong><?= money((int)$order['total']) ?></strong></dd><dt>Placed</dt><dd><?= e($order['created_at']) ?></dd><dt>Notes</dt><dd><?= nl2br(e($order['notes'])) ?: '—' ?></dd></dl></section></div>
<form class="order-update" method="post"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="id" value="<?= $id ?>"><h2>Fulfilment</h2>
<label>Status<select name="order_status"><?php foreach (status_options() as $option): ?><option value="<?= e($option) ?>" <?= $order['order_status'] === $option ? 'selected' : '' ?>><?= e(ucfirst($option)) ?></option><?php endforeach; ?></select></label>
<label>Courier<input name="courier" maxlength="100" value="<?= e($order['courier']) ?>"></label><label>Tracking number<input name="tracking_number" maxlength="100" value="<?= e($order['tracking_number']) ?>"></label><button>Save changes</button></form>
</main></body></html>
