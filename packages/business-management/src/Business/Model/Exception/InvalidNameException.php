<?php

namespace Derhub\BusinessManagement\Business\Model\Exception;

use Derhub\Shared\Exceptions\DomainException;

final class InvalidNameException extends \Exception implements DomainException
{
    public static function fromOnboard(): self
    {
        return new self('name is required when on-boarding business-management');
    }

    public static function fromHandOver(): self
    {
        return new self('name is required when handing business-management');
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
