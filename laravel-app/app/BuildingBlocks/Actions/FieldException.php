<?php

namespace App\BuildingBlocks\Actions;

class FieldException extends \Exception
{
    public static function fieldNotFound(
        string $name,
        array $availableFields
    ): self {
        return new self(
            \sprintf(
                'Field `%s` is in the list of available fields (%s)',
                $name,
                \implode(',', $availableFields)
            )
        );
    }
}
