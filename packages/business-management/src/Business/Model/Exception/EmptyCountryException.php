<?php

namespace Derhub\BusinessManagement\Business\Model\Exception;

use Derhub\Shared\Exceptions\DomainException;

class EmptyCountryException extends \Exception implements DomainException
{
    public static function fromHandOver(): self
    {
        return new self('country is required when handing over');
    }
    public static function fromOnboard(): self
    {
        return new self('country is required when on boarding');
    }
}
