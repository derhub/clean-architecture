<?php

namespace Derhub\Business\Infrastructure\Laravel;

use Derhub\Business\Infrastructure\Database\Doctrine\DoctrineQueryBusinessRepository;
use Derhub\Business\Infrastructure\Database\QueryBusinessRepository;
use Derhub\Business\Infrastructure\Persistence\Doctrine\DoctrineBusinessRepository;
use Derhub\Business\Infrastructure\Persistence\Doctrine\DoctrineTypes;
use Derhub\Business\Infrastructure\Specifications\Doctrine\QueryUniqueNameSpec;
use Derhub\Business\Infrastructure\Specifications\Doctrine\QueryUniqueSlugSpec;
use Derhub\Business\Model\BusinessRepository;
use Derhub\Business\Model\Specification\UniqueNameSpec;
use Derhub\Business\Model\Specification\UniqueSlugSpec;
use Derhub\Business\Services\BusinessItemMapperImpl;
use Derhub\Business\Services\BusinessQueryItemMapper;
use Illuminate\Support\ServiceProvider;

class LaravelServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        DoctrineTypes::register();

        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->publishes(
            [
                __DIR__.'/../Persistence/Database/Doctrine/mapping' =>
                    $this->app->databasePath('doctrine_mapping'),
            ],
            'eb_doctrine_mapping'
        );
    }

    public function register(): void
    {
        $this->app->bind(
            BusinessRepository::class,
            DoctrineBusinessRepository::class
        );
        $this->app->bind(
            QueryBusinessRepository::class,
            DoctrineQueryBusinessRepository::class
        );
        $this->app->bind(BusinessQueryItemMapper::class, BusinessItemMapperImpl::class);
        $this->app->bind(UniqueNameSpec::class, QueryUniqueNameSpec::class);
        $this->app->bind(UniqueSlugSpec::class, QueryUniqueSlugSpec::class);
    }
}
