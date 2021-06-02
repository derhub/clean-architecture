<?php

declare(strict_types=1);

namespace Derhub\BusinessManagement\Business\Model\Exception;

use Derhub\Shared\Exceptions\DomainException;

final class InvalidSlugException extends \Exception implements DomainException
{
    public static function fromHandOver(): self
    {
        return new self('business-management slug is required when hand over');
    }

    public static function fromOnboard(): self
    {
        return new self('business-management slug is required when onboard');
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
