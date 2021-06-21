<?php

namespace Derhub\Shared\Database\Doctrine;

use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\Psr6\DoctrineProvider;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\XmlDriver;
use Doctrine\ORM\Tools\Setup;
use Psr\Cache\CacheItemPoolInterface;

class DoctrineFactory
{
    public static function createConfig(
        bool $devMode,
        ?string $proxyDir = null,
        ?Cache $cachePool = null,
    ): Configuration {
        return Setup::createConfiguration(
            $devMode,
            $proxyDir,
            $cachePool
        );
    }

    /**
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
        ?TenantIdentityProvider $tenantProvider = null,
    ): EntityManagerInterface {
        $setup = self::createConfig(
            $config['dev_mode'] ?? true,
            $config['proxy_dir'] ?? null,
            DoctrineProvider::wrap($cachePool),
        );

        foreach ($config['metadata'] as $path) {
            DoctrineXmlMetadataRegistry::addPath($path);
        }

        $setup->setMetadataDriverImpl(
            new XmlDriver(DoctrineXmlMetadataRegistry::metadata())
        );

        $setup->addFilter('tenant_id', TenantSqlFilter::class);

        $entityManager = EntityManager::create(
            $config['connection'],
            $setup
        );

        if ($tenantProvider) {
            $filter = $entityManager->getFilters()
                ->enable(TenantSqlFilter::NAME)
            ;

            $filter->setParameter(
                TenantSqlFilter::PARAM_KEY,
                $tenantProvider->getTenantId()
            );
        }

        return $entityManager;
    }
}
