<?php

namespace Derhub\Shared\Database\Doctrine\Types;

use InvalidArgumentException;

class InvalidTypeException extends InvalidArgumentException
{
    public static function from($value, $method): self
    {
        return new self(
            printf(
                'Type "%s" is not supported. '.
                'You can override %s method',
                gettype($value),
                $method
            )
        );
    }
}
