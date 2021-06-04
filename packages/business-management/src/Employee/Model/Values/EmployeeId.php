<?php

namespace Derhub\BusinessManagement\Employee\Model\Values;

use Derhub\Shared\Model\AggregateRootId;
use Derhub\Shared\Values\UuidValueObject;

class EmployeeId implements AggregateRootId
{
    use UuidValueObject;

    public function __toString()
    {
        return 'Business employee id';
    }
}