<?php

namespace App\Providers;

use App\BuildingBlocks\LaravelContainer;
use App\DoctrineEntityManagerDecorator;
use App\EntityManagerFactory;
use Derhub\Shared\Container\ContainerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Container\Container;
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

        $this->app->singleton(
            EntityManagerInterface::class,
            function ($app) {
                $factory = $app->make(EntityManagerFactory::class);

                return new DoctrineEntityManagerDecorator($factory);
            }
        );

        $this->app->singleton(
            ContainerInterface::class,
            static fn ($app) => new LaravelContainer(
                static fn () => Container::getInstance()
            )
        );

        $this->boostrapModules();
//        $this->registerDebugBar();
    }

    private function boostrapModules(): void
    {
        // iterate to boostrap and require them
        $moduleBootstraps = config()->get('derhub.module.bootstraps', []);

        // expose container to list of module bootstrap
        $container =
            $this->app->get(\Derhub\Shared\Container\ContainerInterface::class);
        foreach ($moduleBootstraps as $bootstrap) {
            require_once $bootstrap;
        }

        $services = $this->app->get(
            \Derhub\Integration\ModuleService\ModuleService::class
        );

        $modules = config()->get('derhub.module.modules', []);
        foreach ($modules as $module) {
            $services->register($this->app->make($module));
        }

        $services->start();
    }


    /**
     * @throws \DebugBar\DebugBarException
     */
    private function registerDebugBar(): void
    {
        if (! $this->app->isProduction() && ! $this->app->runningInConsole()) {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);

            $loader = AliasLoader::getInstance();
            $loader->alias('Debugbar', \Barryvdh\Debugbar\Facade::class);
            $this->app->singleton(
                'doctrine_debug_stack',
                fn () => new \Doctrine\DBAL\Logging\DebugStack()
            );
            \Debugbar::addCollector(
                new \DebugBar\Bridge\DoctrineCollector(
                    $this->app->get('doctrine_debug_stack')
                )
            );
        }
    }
}
