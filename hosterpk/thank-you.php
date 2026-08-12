<?php
declare(strict_types=1);
require __DIR__ . '/includes/bootstrap.php';
$order = $_SESSION['last_order'] ?? null;
if (!$order) {
    redirect('index.php');
}
unset($_SESSION['last_order']);
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Order received — Herbella</title><link rel="stylesheet" href="assets/css/checkout.min.css"></head>
<body class="checkout-page"><main class="success-card">
<img src="assets/images/crown-mark.svg" alt=""><p class="checkout-kicker">ORDER RECEIVED</p>
<h1>Thank you for choosing <em>Herbella.</em></h1>
<p>Your Cash on Delivery order has been recorded. Our care team will contact you to confirm delivery.</p>
<dl><div><dt>Order number</dt><dd><?= e($order['number']) ?></dd></div>
<div><dt>Order total</dt><dd><?= money((int)$order['total']) ?></dd></div>
<div><dt>Payment</dt><dd>Cash on Delivery</dd></div></dl>
<?php if (!$order['email_sent']): ?><p class="email-note">Your order is safe. Email confirmation is awaiting final setup.</p><?php endif; ?>
<a class="checkout-button" href="index.php">Return home <span>&rarr;</span></a>
</main></body></html>
