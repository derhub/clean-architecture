<?php

namespace Derhub\Template\Infrastructure\Laravel;

use Derhub\Template\Infrastructure\Database\Doctrine\DoctrineTypings;
use Illuminate\Support\ServiceProvider;

class LaravelServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        DoctrineTypings::register();

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
