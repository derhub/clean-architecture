<?php

namespace Derhub\BusinessManagement\Business\Model\Exception;

use Derhub\Shared\Exceptions\DomainException;

class ChangesToDisabledBusinessException extends \Exception implements DomainException
{
    public static function notAllowed(): self
    {
        return new self('Changes to disabled business-management is not allowed');
    }
}
