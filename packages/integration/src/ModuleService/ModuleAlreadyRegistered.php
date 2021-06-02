<?php

namespace Derhub\Integration\ModuleService;

use Derhub\Shared\ModuleInterface;

class ModuleAlreadyRegistered extends \Exception
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
