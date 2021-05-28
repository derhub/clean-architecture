<?php

namespace EB\Template\Infrastructure\Laravel;

use EB\Template\Infrastructure\Specifications\Doctrine\QueryUniqueSampleSpec;
use EB\Template\Model\Specification\UniqueSampleSpec;
use EB\Template\TemplateModule;
use EB\Shared\Container\ContainerInterface;
use Illuminate\Support\ServiceProvider;

class LaravelServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->publishes(
            [
                __DIR__.'/../Persistence/Doctrine/mapping' =>
                    $this->app->databasePath('doctrine_mapping'),
            ],
            'eb_doctrine_mapping'
        );
    }

    public function register(): void
    {
        $this->app->bind(UniqueSampleSpec::class, QueryUniqueSampleSpec::class);

        $module =
            new TemplateModule($this->app->get(ContainerInterface::class));
        $module->start();
    }
}
