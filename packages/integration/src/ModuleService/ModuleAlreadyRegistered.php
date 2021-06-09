<?php

namespace Derhub\Integration\ModuleService;


use Derhub\Shared\Module\ModuleInterface;

class ModuleAlreadyRegistered extends \Exception implements \Derhub\Shared\Module\ModuleAlreadyRegistered
{
    public static function withModule(ModuleInterface $module): self
    {
        return new self(
            sprintf(
                'Module %s already registered',
                $module->getId()
            ),
        );
    }
}
