<?php

namespace Derhub\Business\Model\Exception;

use Derhub\Shared\Exceptions\DomainException;

final class AlreadyHandedException extends \Exception implements DomainException
{
    public static function fromHandOver(): self
    {
        return new self('business already handed');
    }
}