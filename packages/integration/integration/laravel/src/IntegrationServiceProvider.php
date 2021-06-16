<?php

namespace Derhub\Laravel\Integration;

use Derhub\Shared\Container\ContainerInterface;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;

class IntegrationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            ContainerInterface::class,
            static fn ($app) => new LaravelContainer(
                static fn () => Container::getInstance()
            )
        );

        $container = $this->app->make(ContainerInterface::class);
        \Derhub\Integration\DependencyFactory::register($container);
    }
}