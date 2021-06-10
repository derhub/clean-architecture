<?php

namespace App\BuildingBlocks\Actions\Capabilities;

use App\BuildingBlocks\Actions\FieldManager;

trait WithFields
{
    protected static ?FieldManager $computedFields = null;

    public static function getComputedFields(): FieldManager
    {
        return self::$computedFields ??= static::fields();
    }
}
