<?php
declare(strict_types=1);
require __DIR__ . '/includes/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('checkout.php');
}

require_csrf();
if (!empty($_POST['website'])) {
    redirect('thank-you.php');
}
if (!rate_limit('checkout', client_ip(), 5, 600)) {
    $_SESSION['checkout_error'] = 'Too many attempts. Please wait a few minutes and try again.';
    redirect('checkout.php');
}

$clean = static fn(string $key, int $length = 180): string =>
    mb_substr(trim((string)($_POST[$key] ?? '')), 0, $length);

$bundle = $clean('bundle', 20);
$allPackages = packages();
$package = $allPackages[$bundle] ?? null;
$quantity = max(1, min(10, (int)($_POST['quantity'] ?? 1)));
$customerName = $clean('customer_name', 100);
$phone = preg_replace('/[^0-9+\- ]/', '', $clean('phone', 30));
$alternatePhone = preg_replace('/[^0-9+\- ]/', '', $clean('alternate_phone', 30));
$email = strtolower($clean('email', 160));
$province = $clean('province', 100);
$city = $clean('city', 100);
$address = $clean('address', 500);
$landmark = $clean('landmark', 180);
$notes = $clean('notes', 500);

if (!$package || !$customerName || strlen($phone) < 10 || !$province || !$city || !$address) {
    $_SESSION['checkout_error'] = 'Please complete all required delivery details.';
    redirect('checkout.php?bundle=' . urlencode($bundle ?: 'ritual'));
}
if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['checkout_error'] = 'Please enter a valid email address or leave it blank.';
    redirect('checkout.php?bundle=' . urlencode($bundle));
}

$shipping = (int)$config['shipping_fee'];
$subtotal = (int)$package['price'] * $quantity;
$discount = 0;
$total = $subtotal + $shipping - $discount;
$number = order_number();

$stmt = db()->prepare(
    'INSERT INTO orders
    (order_number, customer_name, phone, alternate_phone, email, province, city, address, landmark,
     bundle, bundle_name, quantity, unit_price, shipping, discount, total, payment_method,
     order_status, courier, tracking_number, notes, ip_address, created_at, updated_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NULL, NULL, ?, ?, NOW(), NOW())'
);
$stmt->execute([
    $number, $customerName, $phone, $alternatePhone ?: null, $email ?: null, $province, $city,
    $address, $landmark ?: null, $bundle, $package['name'], $quantity, $package['price'],
    $shipping, $discount, $total, 'Cash on Delivery', 'pending', $notes ?: null, client_ip(),
]);

$order = [
    'order_number' => $number, 'customer_name' => $customerName, 'phone' => $phone,
    'email' => $email, 'province' => $province, 'city' => $city, 'address' => $address,
    'bundle_name' => $package['name'], 'quantity' => $quantity, 'shipping' => $shipping, 'total' => $total,
];
$emailSent = send_order_email($order);
$_SESSION['last_order'] = ['number' => $number, 'total' => $total, 'email_sent' => $emailSent];
redirect('thank-you.php');
