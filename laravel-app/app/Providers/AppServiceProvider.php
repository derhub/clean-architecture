<?php

namespace App\Providers;

use Composer\Autoload\ClassMapGenerator;
use Derhub\Integration\ModuleService\ModuleService;
use Derhub\Shared\Database\Doctrine\DoctrineFactory;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

use function base_path;
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
        $moduleBootstraps = config()->get('derhub.module.bootstraps', []);
        foreach ($moduleBootstraps as $bootstrap) {
            include_once $bootstrap;
        }
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \DebugBar\DebugBarException
     */
    public function register(): void
    {
        $this->app->bind(
            EntityManagerInterface::class,
            static function ($app) {
                $entityManager = DoctrineFactory::createEntityManager(
                    $app['config']->get('database.doctrine_orm'),
                    $app['cache.psr6']
                );

                if ($app->has('doctrine_debug_stack')) {
                    $entityManager
                        ->getConnection()
                        ->getConfiguration()
                        ->setSQLLogger($app->get('doctrine_debug_stack'))
                    ;
                }

                return $entityManager;
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

        $this->registerDebugBar();
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
