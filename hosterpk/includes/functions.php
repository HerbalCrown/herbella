<?php
declare(strict_types=1);

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function redirect(string $path): never
{
    global $config;
    header('Location: ' . rtrim($config['site_url'], '/') . '/' . ltrim($path, '/'));
    exit;
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function require_csrf(): void
{
    $token = (string)($_POST['csrf_token'] ?? '');
    if (!$token || !hash_equals((string)($_SESSION['csrf_token'] ?? ''), $token)) {
        http_response_code(419);
        exit('Your session expired. Please return and try again.');
    }
}

function packages(): array
{
    return [
        'ritual' => ['name' => 'The Ritual', 'units' => 1, 'price' => 650, 'copy' => 'A first taste of Herbella'],
        'duo' => ['name' => 'The Duo', 'units' => 2, 'price' => 1100, 'copy' => 'Share one. Keep one.'],
        'crown' => ['name' => 'The Crown Set', 'units' => 3, 'price' => 1650, 'copy' => 'Your complete 90-day ritual'],
    ];
}

function money(int $amount): string
{
    global $config;
    return $config['currency'] . ' ' . number_format($amount);
}

function client_ip(): string
{
    return substr((string)($_SERVER['REMOTE_ADDR'] ?? 'unknown'), 0, 45);
}

function rate_limit(string $action, string $identifier, int $limit, int $windowSeconds): bool
{
    $pdo = db();
    $key = hash('sha256', $action . '|' . $identifier);
    $cutoff = date('Y-m-d H:i:s', time() - $windowSeconds);
    $pdo->prepare('DELETE FROM rate_limits WHERE created_at < ?')->execute([$cutoff]);
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM rate_limits WHERE action_key = ? AND created_at >= ?');
    $stmt->execute([$key, $cutoff]);
    if ((int)$stmt->fetchColumn() >= $limit) {
        return false;
    }
    $pdo->prepare('INSERT INTO rate_limits (action_key, created_at) VALUES (?, NOW())')->execute([$key]);
    return true;
}

function order_number(): string
{
    return 'HC-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));
}

function send_order_email(array $order): bool
{
    global $config;
    $email = $config['email'];
    if (empty($email['resend_api_key']) || empty($email['from'])) {
        return false;
    }

    $subject = 'Herbal Crown order ' . $order['order_number'] . ' - ' . money((int)$order['total']);
    $body = '<h1>New Cash on Delivery order</h1>'
        . '<p><strong>Order:</strong> ' . e($order['order_number']) . '<br>'
        . '<strong>Customer:</strong> ' . e($order['customer_name']) . '<br>'
        . '<strong>Phone:</strong> ' . e($order['phone']) . '<br>'
        . '<strong>Delivery:</strong> ' . e($order['address']) . ', ' . e($order['city']) . ', ' . e($order['province']) . '</p>'
        . '<p><strong>' . e($order['bundle_name']) . ' &times; ' . (int)$order['quantity'] . '</strong><br>'
        . 'Shipping: ' . money((int)$order['shipping']) . '<br>'
        . 'Total COD: <strong>' . money((int)$order['total']) . '</strong></p>';

    $recipients = array_values(array_filter([$email['orders_to'], $order['email']]));
    $payload = json_encode([
        'from' => $email['from'],
        'to' => $recipients,
        'subject' => $subject,
        'html' => '<div style="font-family:Arial,sans-serif;max-width:680px;margin:auto;padding:28px;border:1px solid #ddd">' . $body . '</div>',
    ], JSON_UNESCAPED_SLASHES);

    $ch = curl_init('https://api.resend.com/emails');
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . $email['resend_api_key'],
            'Content-Type: application/json',
        ],
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_TIMEOUT => 15,
    ]);
    curl_exec($ch);
    $status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $status >= 200 && $status < 300;
}

function admin_logged_in(): bool
{
    return !empty($_SESSION['admin_id']) && !empty($_SESSION['admin_last_seen'])
        && (time() - (int)$_SESSION['admin_last_seen']) < 1800;
}

function require_admin(): void
{
    if (!admin_logged_in()) {
        $_SESSION = [];
        redirect('admin/login.php');
    }
    $_SESSION['admin_last_seen'] = time();
}

function status_options(): array
{
    return ['pending', 'confirmed', 'shipped', 'delivered', 'cancelled'];
}
