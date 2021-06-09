<?php

namespace App\BuildingBlocks\Actions;

use Symfony\Component\Finder\Finder;

class AutoRegisterActionRoutes
{
    public static function routes(): void
    {
        // TODO: cache auto load action routes
        $actionFinder = (new Finder())
            ->in(base_path('app/Actions/*'))
            ->notPath(['#^Samples#'])
            ->name('*.php')
            ->notName(['/Generated/', '/SampleAction/'])
            ->ignoreDotFiles(true)
        ;
//        \dd(\array_keys(\iterator_to_array($actionFinder->getIterator())));
        /** @var \Symfony\Component\Finder\SplFileInfo $info */
        foreach ($actionFinder->getIterator() as $file => $info) {
            $className = '\App\\'.str_replace(
                    [base_path('app').'/', '.php', '/'],
                    ['', '', '\\'],
                    $info->getRealPath()
                );

            if (! class_exists($className, true)) {
                continue;
            }

            if ($className::disableRoutesAutoLoad()) {
                continue;
            }

            // load routes
            $className::routes();
        }
    }
}