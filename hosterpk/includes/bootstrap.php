<?php
declare(strict_types=1);

$localConfig = __DIR__ . '/config.local.php';
if (!is_file($localConfig)) {
    http_response_code(503);
    exit('Website configuration is incomplete.');
}

$config = require $localConfig;
date_default_timezone_set((string)($config['timezone'] ?? 'Asia/Karachi'));

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_name('herbella_session');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/functions.php';
