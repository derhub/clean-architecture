<?php

namespace Derhub\Business\Infrastructure\Laravel;

use Derhub\Business\Infrastructure\Database\Doctrine\DoctrineTypes;
use Illuminate\Support\ServiceProvider;

class LaravelServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        DoctrineTypes::register();

        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->publishes(
            [
                __DIR__.'/../Database/Doctrine/mapping' =>
                    $this->app->databasePath('doctrine_mapping'),
            ],
            'eb_doctrine_mapping'
        );
    }

    public function register(): void
    {
    }
}
