<?php

namespace Derhub\Shared\Integrations\Laravel;

use Doctrine\ORM\EntityManagerInterface;
use Derhub\Shared\Container\ContainerInterface;
use Derhub\Shared\Infrastructure\TacticianBus\MessageBusFactory;
use Derhub\Shared\Message\Command\CommandBus;
use Derhub\Shared\Message\Command\CommandListenerProvider;
use Derhub\Shared\Message\Query\QueryBus;
use Derhub\Shared\Message\Query\QueryListenerProvider;
use Derhub\Shared\MessageOutbox\MessageOutboxObjectWrapper;
use Derhub\Shared\MessageOutbox\MessageOutboxObjectWrapperFactory;
use Derhub\Shared\Persistence\Doctrine\DoctrineFactory;
use Illuminate\Support\ServiceProvider;

class LaravelServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes(
            [
                __DIR__.'/config/eb.doctrine_orm.php' => $this->app->configPath(
                    'eb.doctrine_orm.php'
                ),
            ],
            'earlybird'
        );
    }

    public function register(): void
    {
        $this->app->bind(
            MessageOutboxObjectWrapper::class,
            MessageOutboxObjectWrapperFactory::class
        );
        $this->registerDoctrine();
    }

    public function registerDoctrine(): void
    {
        DoctrineFactory::registerDefaultTypes();

        $this->app->singleton(
            EntityManagerInterface::class,
            static function ($app) {
                return DoctrineFactory::createEntityManager(
                    $app['config']['eb.doctrine_orm']
                );
            }
        );
    }

}
