<?php

namespace App\BuildingBlocks\Actions\Capabilities;

trait WithRouting
{
    /**
     * Return true to disable route registration
     * @return bool
     * @see AutoRegisterActionRoutes
     */
    public static function disableAutoRegisterRoutes(): bool
    {
        return false;
    }

    public static function routes(): void
    {
        $method = static::ROUTE_METHOD;

//        $action = \app()->make(static::class);
//        \Octane::route(
//            \Str::upper($method),
//            static::ROUTE,
//            fn (...$args) => $action(...$args)
//        );

        \Illuminate\Support\Facades\Route::{$method}(
            static::ROUTE,
            static::class
        )
            ->name(static::ROUTE_NAME)
        ;
    }
}
