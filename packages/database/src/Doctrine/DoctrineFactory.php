<?php

namespace Derhub\Shared\Database\Doctrine;

use Doctrine\Common\Cache\Psr6\DoctrineProvider;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Setup;
use Psr\Cache\CacheItemPoolInterface;

class DoctrineFactory
{
    /**
     * @param array $config
     * @param \Psr\Cache\CacheItemPoolInterface $cachePool
     * @return \Doctrine\ORM\EntityManagerInterface
     * @throws \Doctrine\ORM\ORMException config:
     * [
     *      'dev_mode' => false,
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
        CacheItemPoolInterface $cachePool,
    ): EntityManagerInterface {

        $setup = Setup::createXMLMetadataConfiguration(
            $config['metadata'],
            $config['dev_mode'],
            $config['proxy_dir'] ?? null,
            DoctrineProvider::wrap($cachePool)
        );

        return EntityManager::create(
            $config['connection'],
            $setup
        );
    }
}
