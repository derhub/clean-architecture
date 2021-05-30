<?php

namespace Derhub\Business\Infrastructure\Laravel;

use Derhub\Business\Infrastructure\Database\Doctrine\BusinessDoctrineTypes;
use Illuminate\Support\ServiceProvider;

class LaravelServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        BusinessDoctrineTypes::register();

        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->publishes(
            [
                __DIR__.'/../Database/Doctrine/mapping' =>
                    $this->app->databasePath('doctrine_mapping'),
            ],
            'doctrine_mapping'
        );
    }

    public function register(): void
    {
    }
}
