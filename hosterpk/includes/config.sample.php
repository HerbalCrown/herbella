<?php
declare(strict_types=1);

return [
    'site_url' => 'https://herbalcrown.pk',
    'timezone' => 'Asia/Karachi',
    'db' => [
        'host' => 'localhost',
        'port' => 3306,
        'name' => 'CPANEL_DATABASE_NAME',
        'user' => 'CPANEL_DATABASE_USER',
        'password' => 'CHANGE_ME',
        'charset' => 'utf8mb4',
    ],
    'email' => [
        'resend_api_key' => '',
        'from' => 'Herbal Crown <orders@herbalcrown.pk>',
        'orders_to' => 'herbalcrownhairoil@gmail.com',
    ],
    'shipping_fee' => 300,
    'currency' => 'Rs',
    'whatsapp_number' => '923000000000',
    'admin_setup_key' => 'REPLACE_WITH_A_LONG_RANDOM_SECRET',
];
