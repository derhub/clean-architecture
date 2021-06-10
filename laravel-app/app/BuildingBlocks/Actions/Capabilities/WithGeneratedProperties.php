<?php

namespace App\BuildingBlocks\Actions\Capabilities;

trait WithGeneratedProperties
{
    public static function getActionId(): string
    {
        return static::ACTION_ID;
    }

    public static function getModuleId(): string
    {
        return static::MODULE;
    }

    public static function getCommandType(): string
    {
        return static::COMMAND_TYPE;
    }

    public static function getRoutePath(): string
    {
        return static::ROUTE;
    }

    public static function getRouteName(): string
    {
        return static::ROUTE_NAME;
    }

    public static function getRouteMethod(): string
    {
        return static::ROUTE_METHOD;
    }

    public static function getGeneratedFields(): array
    {
        return static::FIELDS;
    }

    public static function getCommandClass(): string
    {
        return static::COMMAND_CLASS;
    }
}