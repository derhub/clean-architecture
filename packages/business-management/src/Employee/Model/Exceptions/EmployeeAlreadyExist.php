<?php

namespace Derhub\BusinessManagement\Employee\Model\Exceptions;

use Derhub\Shared\Exceptions\DomainException;

use function sprintf;

class EmployeeAlreadyExist extends \Exception implements DomainException
{
    public static function withName(string $name): self
    {
        return new self(
            sprintf('Employee with %s already exist', $name),
        );
    }
}