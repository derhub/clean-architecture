<?php

namespace Derhub\Business\Model\Exception;

use Derhub\Business\Model\Business;
use Derhub\Shared\Exceptions\DomainException;
use Throwable;

class ChangesToDisabledBusinessException extends \Exception implements DomainException
{
    public static function notAllowed(): self
    {
        return new self('Changes to disabled business is not allowed');
    }
}
