<?php

namespace Derhub\BusinessManagement\Employee\Model\Exceptions;

use Derhub\Shared\Exceptions\DomainException;

class ChangesToDeletedEmployee extends \Exception
    implements DomainException
{
    public static function notAllowed(): self
    {
        return new self('changes to deleted employee is not allowed');
    }
}