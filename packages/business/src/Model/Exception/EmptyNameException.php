<?php

namespace Derhub\Business\Model\Exception;

use Derhub\Shared\Exceptions\DomainException;

class EmptyNameException extends \Exception implements DomainException
{
    public static function fromOnboard(): self
    {
        return new self('name is required when on-boarding business');
    }

    public static function fromHandOver()
    {
        return new self('name is required when handing business');
    }
}