<?php

namespace Derhub\BusinessManagement\Business\Infrastructure\Laravel;

use Derhub\BusinessManagement\Business\Infrastructure\Database\Doctrine\BusinessDoctrineTypes;
use Illuminate\Support\ServiceProvider;

class LaravelServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        BusinessDoctrineTypes::register();

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
