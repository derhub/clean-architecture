<?php

namespace Derhub\Laravel\Database;

use Derhub\Shared\Database\Doctrine\DatabaseDoctrineTypes;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Support\ServiceProvider;

class DatabaseServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        DatabaseDoctrineTypes::register();

        $this->app->bind(
            \Derhub\Shared\Persistence\PersistenceRepository::class,
            \Derhub\Shared\Database\Doctrine\DoctrinePersistenceRepository::class
        );

        $this->app->bind(
            \Derhub\Shared\Database\DBTransaction::class,
            \Derhub\Shared\Database\Doctrine\DoctrineDBTransaction::class
        );


        $this->app->singleton(
            EntityManagerInterface::class,
            function ($app) {
                $factory = $app->make(EntityManagerFactory::class);

                return new DoctrineEntityManagerDecorator($factory);
            }
        );


        $this->booting(
            function () {
                /** @var \Barryvdh\Debugbar\LaravelDebugbar $debugbar */
                $debugbar = $this->app->get('debugbar');

                $doctrineCollector =
                    $this->app->get('doctrine_debug_stack');
                $em = $this->app->get(EntityManagerInterface::class);
                $debugbar->addCollector(
                    LaravelDoctrineDebugBar::create(
                        $debugbar,
                        $doctrineCollector,
                        $em
                    )
                );
            }
        );
    }
}
