<?php

namespace Derhub\BusinessManagement\Employee\Model\Values;

use Derhub\Shared\Values\UuidValueObject;
use Derhub\Shared\Values\ValueObjectStr;

class EmployeePosition implements ValueObjectStr
{
    use UuidValueObject;

    public function __toString()
    {
        if ($this->isEmpty()) {
            return 'empty employee position';
        }

        return 'employee position id: '.$this->id();
    }

    public function id(): string
    {
        return $this->value;
    }
}