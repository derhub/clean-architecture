<?php

namespace App\BuildingBlocks\Actions;

use Symfony\Component\Finder\Finder;

class AutoRegisterActionRoutes
{
    public static function routes(): void
    {
        $actionFinder = (new Finder())
            ->in(base_path('app/Actions'))
            ->notPath(['#^Samples#'])
            ->name('*.php')
            ->notName(['/Generated/', '/SampleAction/'])
            ->ignoreDotFiles(true)
        ;

        /** @var \Symfony\Component\Finder\SplFileInfo $info */
        foreach ($actionFinder as $info) {
            $className = '\App\\'.
                str_replace(
                    [base_path('app').'/', '.php', '/'],
                    ['', '', '\\'],
                    $info->getRealPath()
                );

            if (! class_exists($className, true)) {
                continue;
            }

            if (! \is_a($className, Action::class, true)) {
                continue;
            }

            /** @var \App\BuildingBlocks\Actions\Action $className */
            if (\method_exists($className, 'disableAutoRegisterRoutes') &&
                $className::disableAutoRegisterRoutes()) {
                continue;
            }

            // load routes
            $className::routes();
        }
    }
}
