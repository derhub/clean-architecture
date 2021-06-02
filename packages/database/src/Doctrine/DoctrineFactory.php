<?php

namespace Derhub\Shared\Database\Doctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Setup;

class DoctrineFactory
{
    /**
     * @throws \Doctrine\ORM\ORMException
     * config:
     * [
     *      'dev_mode' => false,
     *      'cache_dir' => '...dir here',
     *      'proxy_dir' => '...dir here',
     *      'metadata' => ['...dir here'],
     *      'connection' => [
     *          'driver' => 'pdo_mysql',
     *          'host' => '..',
     *          'port' => '..',
     *          'dbname' => '..',
     *          'user' => '..',
     *          'password' => '..',
     *          'charset' => '..',
     *      ],
     * ]
     */
    public static function createEntityManager(
        array $config,
    ): EntityManagerInterface {
//        $cache = isset($config['cache_dir']) ? new PhpFileCache($config['cache_dir']) : new ArrayCache();
        $setup = Setup::createXMLMetadataConfiguration(
            $config['metadata'],
            $config['dev_mode'],
            $config['proxy_dir'] ?? null,
        );

        return EntityManager::create(
            $config['connection'],
            $setup
        );
    }
    public static function registerDefaultTypes(): void
    {
    }
}
