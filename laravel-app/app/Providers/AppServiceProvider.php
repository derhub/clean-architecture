<?php

namespace App\Providers;

use App\DoctrineEntityManagerDecorator;
use App\EntityManagerFactory;
use Derhub\Integration\ModuleService\ModuleService;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

use function config;

class AppServiceProvider extends ServiceProvider
{
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

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $moduleBootstraps = config()->get('derhub.module.bootstraps', []);
        foreach ($moduleBootstraps as $bootstrap) {
            include_once $bootstrap;
        }
    }

    public function register(): void
    {
        $this->app->singleton(
            EntityManagerInterface::class,
            function ($app) {
                $factory = $app->make(EntityManagerFactory::class);

                return new DoctrineEntityManagerDecorator($factory);
            }
        );


        $this->app->register(
            \Derhub\Integration\Laravel\LaravelServiceProvider::class,
        );

        /** @var ModuleService $moduleService */
        $moduleService = $this->app->make(ModuleService::class);
        foreach (config('derhub.module.modules', []) as $module) {
            $moduleService->register($this->app->make($module));
        }
        $moduleService->start();
//        $this->registerDebugBar();
    }
}
