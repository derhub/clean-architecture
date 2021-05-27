<?php

namespace Derhub\Business\Model\Exception;

use Derhub\Shared\Exceptions\DomainException;

class EmptyOwnerIdException extends \Exception implements DomainException
{
    public static function fromOnboard(): self
    {
        return new self('owner id is required when on-boarding business');
    }

    public static function fromHandOver(): self
    {
        return new self('owner id is required when handing business');
    }
}