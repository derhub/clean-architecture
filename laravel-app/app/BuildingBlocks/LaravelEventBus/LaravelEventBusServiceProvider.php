<?php

namespace App\BuildingBlocks\LaravelEventBus;

use Derhub\Shared\Message\Event\EventBus;
use Derhub\Shared\Message\Event\EventListenerProvider;
use Illuminate\Support\ServiceProvider;

class LaravelEventBusServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            EventBus::class,
            static function ($app) {
                return new EventLaravelBus(
                    $app->get(EventListenerProvider::class)
                );
            }
        );

        $this->app->singleton(
            EventListenerProvider::class,
            EventHandlerProvider::class,
        );
    }
}