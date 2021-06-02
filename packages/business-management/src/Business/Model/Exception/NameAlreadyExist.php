<?php

namespace Derhub\BusinessManagement\Business\Model\Exception;

use Derhub\BusinessManagement\Business\Model\Values\Name;
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
