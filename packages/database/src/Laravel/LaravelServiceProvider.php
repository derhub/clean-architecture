<?php

namespace Derhub\Shared\Database\Laravel;

use Derhub\Shared\Database\Doctrine\DoctrineFactory;
use Derhub\Shared\Database\Doctrine\DoctrinePersistenceRepository;
use Derhub\Shared\Database\Doctrine\SharedDoctrineTypes;
use Derhub\Shared\Persistence\DatabasePersistenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Support\ServiceProvider;

class LaravelServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
    }

    public function register(): void
    {
        SharedDoctrineTypes::register();

        $this->app->bind(DatabasePersistenceRepository::class, DoctrinePersistenceRepository::class);
        $this->app->bind(
            EntityManagerInterface::class,
            static function ($app) {
                return DoctrineFactory::createEntityManager(
                    $app['config']->get('database.doctrine_orm')
                );
            }
        );
    }
}