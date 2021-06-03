<?php

$currentPath = __DIR__;

include_once $currentPath.'/vendor/autoload.php';

$dotEnv = Dotenv\Dotenv::createImmutable($currentPath);
$dotEnv->load();

return [
    'version_order' => 'creation',
    'paths' => [
        'migrations' => ['%%PHINX_CONFIG_DIR%%/vendor/derhub/*/db/migrations'],
        'seeds' => ['%%PHINX_CONFIG_DIR%%/vendor/derhub/*/db/seeders'],
    ],
    'environments' => [
        'default_migration_table' => 'migration_log',
        'default_environment' => 'default',
        'default' => [
            'adapter' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', 3306),
            'name' => env('DB_DATABASE', 'laravel_db'),
            'user' => env('DB_USERNAME', 'root'),
            'pass' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
        ],
    ],
];
