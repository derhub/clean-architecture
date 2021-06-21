<?php

return [
    'dev_mode' => false, //env('APP_ENV') !== 'production',
    'proxy_dir' => storage_path('doctrine_cache'),
    'metadata' => [],
    'connection' => [
        'driver' => 'pdo_mysql',
        'host' => env('DB_HOST', '127.0.0.1'),
        'port' => env('DB_PORT', '3306'),
        'dbname' => env('DB_DATABASE', 'forge'),
        'user' => env('DB_USERNAME', 'forge'),
        'password' => env('DB_PASSWORD', ''),
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
    ],
];
