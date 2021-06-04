<?php

namespace Derhub\BusinessManagement\Employee\Model\Values;

use Derhub\Shared\Values\UuidValueObject;
use Derhub\Shared\Values\ValueObjectStr;

class EmployerId implements ValueObjectStr
{
    use UuidValueObject;

    public function __toString()
    {
        if ($this->isEmpty()) {
            return 'unknown business id of employee';
        }

        return 'business id of employee: '.$this->toString();
    }
}