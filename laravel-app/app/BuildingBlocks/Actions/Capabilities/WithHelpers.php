<?php

namespace App\BuildingBlocks\Actions\Capabilities;

trait WithHelpers
{
    protected static function hideField(
        array &$fields,
        string $field,
        mixed $value
    ): void {
        if (! isset($fields[$field])) {
            return;
        }

        $fields[$field]['hidden'] ??= true;
        $fields[$field]['default'] = $value;
        $fields[$field]['required'] = false;
    }

    protected static function fieldOption(
        array &$fields,
        string $field,
        array $options
    ): void {
        if (! isset($fields[$field])) {
            return;
        }

        $fields[$field]['options'] = $options;
    }
}