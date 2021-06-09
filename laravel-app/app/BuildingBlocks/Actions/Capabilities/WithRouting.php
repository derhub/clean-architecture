<?php

namespace App\BuildingBlocks\Actions\Capabilities;

trait WithRouting
{
    public static function disableRoutesAutoLoad(): bool
    {
        return false;
    }

    public static function routes(): void
    {
        $method = static::ROUTE_METHOD;
//        $action = \app()->make(static::class);
//
//        \Octane::route(
//            \Str::upper($method), static::ROUTE,
//            static function (...$args) use (
//                $action
//            ) {
//                return $action(...$args);
//            }
//        );
        \Illuminate\Support\Facades\Route::{$method}(
            static::ROUTE,
            static::class
        )
            ->name(static::ROUTE_NAME)
        ;
    }
}
