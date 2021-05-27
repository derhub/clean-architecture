<?php

namespace Derhub\Business\Model\Exception;

use Derhub\Business\Model\Values\Name;
use Derhub\Shared\Exceptions\DomainException;

class NameAlreadyExist extends \Exception implements DomainException
{
    public static function withName(Name $name): self
    {
        return new self(
            sprintf('%s already exist.', $name->__toString())
        );
    }
}