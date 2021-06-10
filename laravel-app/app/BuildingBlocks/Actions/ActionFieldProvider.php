<?php

namespace App\BuildingBlocks\Actions;

use App\BuildingBlocks\Actions\Fields\BaseField;
use ArrayIterator;

class ActionFieldProvider implements FieldProvider
{
    private static array $items = [];

    public function __construct()
    {
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator(self::$items);
    }

    public function offsetExists($offset): bool
    {
        return isset(self::$items[$offset]);
    }

    public function offsetGet($offset)
    {
        return self::$items[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        self::$items[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset(self::$items[$offset]);
    }

    public static function extendForAction(string $actionId, Field $field): void
    {
        self::$items[$actionId.'.'.$field->name()] = $field;
    }

    public static function get(string $key): ?BaseField
    {
        return self::$items[$key] ?? null;
    }
}