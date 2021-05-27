<?php

return [
    'dev_mode' => true,
    'cache_dir' => '',
    'mappings' => [
//        __DIR__.'/../src/Infrastructure/Persistence/Doctrine/mapping',
    ],
    'connection' => [
        'driver' => 'pdo_mysql',
        'host' => '127.0.0.1',
        'port' => '3306',
        'dbname' => 'eb_ddd',
        'user' => 'admin',
        'password' => 'admin',
        'charset' => 'utf8mb4',
    ],
];