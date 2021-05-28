<?php

namespace Derhub\Business\Model\Exception;

use Derhub\Shared\Exceptions\DomainException;

class InvalidOwnerIdException extends \Exception implements DomainException
{
    public static function fromOnboard(): self
    {
        return new self('owner id is required when on-boarding business');
    }

    public static function fromHandOver(): self
    {
        return new self('owner id is required when handing business');
    }

    public static function fromException(DomainException|\Exception $e): self
    {
        return new self(
            $e->getMessage(),
            $e->getCode(),
            $e,
        );
    }
}