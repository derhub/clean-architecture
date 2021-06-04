<?php

namespace Derhub\Shared\Database\Migration;

class MigrationHelper
{
    public static function createPhinxConfig(
        array|string $migrations,
        array|string $seeders,
        ?string $loadDotEnv = null,
    ): array {
        if (is_string($loadDotEnv)) {
            self::loadDotEnv($loadDotEnv);
        }

        return [
            'version_order' => 'creation',
            'paths' => [
                'migrations' => $migrations,
                'seeds' => $seeders,
            ],
            'environments' => [
                'default_migration_table' => 'phinx_migration_log',
                'default_environment' => 'default',
                'default' => [
                    'adapter' => 'mysql',
                    'host' => self::getEnv('DB_HOST', '127.0.0.1'),
                    'port' => self::getEnv('DB_PORT', 3306),
                    'name' => self::getEnv('DB_DATABASE', 'laravel_db'),
                    'user' => self::getEnv('DB_USERNAME', 'root'),
                    'pass' => self::getEnv('DB_PASSWORD', ''),
                    'charset' => self::getEnv('DB_CHARSET', 'utf8'),
                ],
            ],
        ];
    }
    public static function createPhinxConfigForModule(
        null|string|array $loadDotEnv = null
    ): array {
        return self::createPhinxConfig(
            migrations: 'configs/migrations',
            seeders: 'configs/migrations',
            loadDotEnv: $loadDotEnv
        );
    }

    public static function getEnv(string $key, mixed $default): mixed
    {
        return env($key, $default);
    }

    public static function loadDotEnv(string|array $dotEnvDir): void
    {
        $dotEnv = \Dotenv\Dotenv::createImmutable($dotEnvDir);
        $dotEnv->load();
    }
}
