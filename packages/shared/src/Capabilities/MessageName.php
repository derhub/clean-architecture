<?php

namespace Derhub\Shared\Capabilities;

use Derhub\Shared\ModuleInterface;

class MessageName
{
    public static function for(
        string $moduleId,
        string $serviceType,
        string $class
    ): string {
        $className = ClassNameCapability::name($class);
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