<?php

namespace Derhub\BusinessManagement\Business\Infrastructure\Laravel;

use Derhub\BusinessManagement\Business\Infrastructure\Database\Doctrine\BusinessDoctrineTypes;
use Illuminate\Support\ServiceProvider;

class LaravelServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        BusinessDoctrineTypes::register();
    }

    public function register(): void
    {
    }
}
