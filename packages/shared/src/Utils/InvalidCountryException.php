<?php

namespace Derhub\Shared\Utils;

use Derhub\Shared\Exceptions\DomainException;

class InvalidCountryException extends \Exception implements DomainException
{
    public static function fromKey(string $key): self
    {
        return new self(
            sprintf('invalid alpha2 country value %s', $key)
        );
    }
}