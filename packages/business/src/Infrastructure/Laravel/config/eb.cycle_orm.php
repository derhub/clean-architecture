<?php

return [
    'database' => [
        'default' => 'default',

        'databases' => [
            'default' => [
                'connection' => env('DB_CONNECTION', 'mysql'),
            ],
        ],

        'connections' => [
            'sqlite' => [
                'driver' => Spiral\Database\Driver\SQLite\SQLiteDriver::class,
                'options' => [
                    'connection' => sprintf('sqlite:%s', env('DB_DATABASE')),
                    'username' => env('DB_USERNAME', 'root'),
                    'password' => env('DB_PASSWORD'),
                ],
            ],

            'mysql' => [
                'driver' => Spiral\Database\Driver\MySQL\MySQLDriver::class,
                'options' => [
                    'connection' => sprintf(
                        'mysql:host=%s;port=%d;dbname=%s',
                        env('DB_HOST', '127.0.0.1'),
                        env('DB_PORT', 3304),
                        env('DB_DATABASE', 'homestead')
                    ),
                    'username' => env('DB_USERNAME', 'root'),
                    'password' => env('DB_PASSWORD'),
                ],
            ],

            'postgres' => [
                'driver' => Spiral\Database\Driver\Postgres\PostgresDriver::class,
                'options' => [
                    'connection' => sprintf(
                        'pgsql:host=%s;port=%d;dbname=%s;',
                        env('DB_HOST', '127.0.0.1'),
                        env('DB_PORT', 5432),
                        env('DB_DATABASE', 'homestead')
                    ),
                    'username' => env('DB_USERNAME', 'root'),
                    'password' => env('DB_PASSWORD'),
                ],
            ],
        ],
    ],
];