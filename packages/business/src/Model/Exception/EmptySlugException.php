<?php

declare(strict_types=1);

namespace Derhub\Business\Model\Exception;

use Derhub\Shared\Exceptions\DomainException;

final class EmptySlugException extends \Exception implements DomainException
{
    public static function fromHandOver(): self
    {
        return new self('business slug is required when hand over');
    }

    public static function fromOnboard(): self
    {
        return new self('business slug is required when onboard');
    }

    public static function fromChangeSlug(): self
    {
        return new self('business slug already exists');
    }
}