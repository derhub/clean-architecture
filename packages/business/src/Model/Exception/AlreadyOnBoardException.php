<?php

namespace Derhub\Business\Model\Exception;

use Derhub\Shared\Exceptions\DomainException;

class AlreadyOnBoardException extends \Exception implements DomainException
{

    public static function fromOnboard(): self
    {
        return new self('business already onboarded');
    }
}