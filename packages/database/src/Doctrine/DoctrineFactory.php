<?php

namespace Derhub\Shared\Database\Doctrine;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\PhpFileCache;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Setup;
use Derhub\Shared\Database\Doctrine\Types\DateTimeLiteralType;
use Derhub\Shared\Database\Doctrine\Types\EmailType;
use Derhub\Shared\Database\Doctrine\Types\UserIdType;

class DoctrineFactory
{
    public static function registerDefaultTypes(): void
    {
        Type::addType(UserIdType::NAME, UserIdType::class);
        Type::addType(EmailType::NAME, EmailType::class);
        Type::addType(
            DateTimeLiteralType::NAME,
            DateTimeLiteralType::class
        );
    }

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
            new ArrayCache(),
        );

        return EntityManager::create(
            $config['connection'],
            $setup
        );
    }
}
