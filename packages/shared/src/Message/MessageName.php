<?php

namespace Derhub\Shared\Message;

use Derhub\Shared\Module\ModuleInterface;
use Derhub\Shared\Utils\ClassName;

class MessageName
{
    public const COMMAND = 'commands';
    public const QUERY = 'queries';
    public const EVENT = 'events';

    public static function for(
        string $moduleId,
        string $serviceType,
        string $class
    ): string {
        $className = ClassName::for($class);

        return "{$moduleId}.{$serviceType}.{$className}";
    }

    public static function forCommand(
        string $moduleId,
        string $class,
    ): string {
        return self::for(
            $moduleId,
            ModuleInterface::SERVICE_COMMANDS,
            $class
        );
    }

    public static function forEvent(
        $moduleId,
        string $class,
    ): string {
        return self::for(
            $moduleId,
            ModuleInterface::SERVICE_EVENTS,
            $class
        );
    }

    public static function forQuery(
        $moduleId,
        string $class,
    ): string {
        return self::for(
            $moduleId,
            ModuleInterface::SERVICE_QUERIES,
            $class
        );
    }
}
