<?php

namespace App\Providers;

use App\DoctrineLoggerWithSource;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

use function config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        \Validator::extend(
            \App\Rules\SlugRule::NAME,
            \App\Rules\SlugRule::class
        );
    }

    public function register(): void
    {
        $this->app->register(
            \App\BuildingBlocks\LaravelEventBus\LaravelEventBusServiceProvider::class
        );

        $this->app->register(\Derhub\Laravel\Database\DatabaseServiceProvider::class);
        $this->app->register(\Derhub\Laravel\Integration\IntegrationServiceProvider::class);
        $this->app->register(\Derhub\Laravel\IdentityAccess\IdentityAccessServiceProvider::class);

        $this->boostrapModules();
        $this->registerDebugBar();
    }

    private function boostrapModules(): void
    {
        $services = $this->app->get(
            \Derhub\Integration\ModuleService\ModuleService::class
        );

        $modules = config()->get('derhub.module.modules', []);
        foreach ($modules as $module) {
            $services->register($this->app->make($module));
        }

        $services->start();
    }


    private function registerDebugBar(): void
    {
        if (! $this->app->isProduction()) {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);

            $loader = AliasLoader::getInstance();
            $loader->alias('Debugbar', \Barryvdh\Debugbar\Facade::class);
            $this->app->singleton(
                'doctrine_debug_stack',
                fn () => new DoctrineLoggerWithSource()
            );
        }
    }
}
