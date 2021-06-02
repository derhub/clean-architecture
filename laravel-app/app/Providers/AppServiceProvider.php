<?php

namespace App\Providers;

use Derhub\Integration\ModuleService\ModuleService;
use Derhub\Shared\Database\Doctrine\DatabaseDoctrineTypes;
use Derhub\Shared\Database\Doctrine\DoctrineFactory;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \DebugBar\DebugBarException
     */
    public function register(): void
    {
        DatabaseDoctrineTypes::register();

        $this->app->bind(
            EntityManagerInterface::class,
            static function ($app) {
                return DoctrineFactory::createEntityManager(
                    $app['config']->get('database.doctrine_orm')
                );
            }
        );

        $this->app->register(
            \Derhub\Integration\Laravel\LaravelServiceProvider::class,
        );
        $this->app->register(
            \Derhub\BusinessManagement\Business\Infrastructure\Laravel\LaravelServiceProvider::class
        );

        /** @var ModuleService $moduleService */
        $moduleService = $this->app->make(ModuleService::class);
        $moduleService->register(
            $this->app->make(\Derhub\Shared\Database\Module::class),
            $this->app->make(\Derhub\BusinessManagement\Module::class)
        );
        $moduleService->start();

        $this->registerDebugBar();
    }

    /**
     * @throws \DebugBar\DebugBarException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function registerDebugBar(): void
    {
        if (! $this->app->isProduction() && ! $this->app->runningInConsole()) {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);

            $loader = AliasLoader::getInstance();
            $loader->alias('Debugbar', \Barryvdh\Debugbar\Facade::class);
            $debugStack = new \Doctrine\DBAL\Logging\DebugStack();
            $this->app->make(EntityManagerInterface::class)
                ->getConnection()
                ->getConfiguration()
                ->setSQLLogger($debugStack)
            ;
            \Debugbar::addCollector(
                new \DebugBar\Bridge\DoctrineCollector($debugStack)
            );
        }
    }
}
