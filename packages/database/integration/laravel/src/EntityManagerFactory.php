<?php

namespace Derhub\Laravel\Database;

use Derhub\Shared\Database\Doctrine\DoctrineFactory;
use Illuminate\Container\Container;

class EntityManagerFactory
{
    public function __construct(private Container $app)
    {
    }

    public function __invoke(): \Doctrine\ORM\EntityManagerInterface
    {
        $app = $this->app;
        $instance = DoctrineFactory::createEntityManager(
            $app['config']->get('database.doctrine_orm'),
            $app['cache.psr6']
        );

        if ($app->has('doctrine_debug_stack')) {
            $instance
                ->getConnection()
                ->getConfiguration()
                ->setSQLLogger(
                    $app->get(
                        'doctrine_debug_stack'
                    )
                )
            ;
        }

        return $instance;
    }
}