<?php

namespace Derhub\BusinessManagement\Employee\Model\Specifications;

use Derhub\BusinessManagement\Employee\Model\Values\EmployeePosition;
use Derhub\BusinessManagement\Employee\Model\Values\EmployerId;
use Derhub\BusinessManagement\Employee\Model\Values\Initial;
use Derhub\Shared\Values\DateTimeLiteral;
use Derhub\Shared\Values\Email;

class UniqueEmployee
{
    public function __construct(
        private EmployerId $employerId,
        private string $name,
        private Initial $initial,
        private EmployeePosition $position,
        private Email $email,
        private DateTimeLiteral $birthday,
    ) {
    }

    public function employerId(): EmployerId
    {
        return $this->employerId;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function initial(): Initial
    {
        return $this->initial;
    }

    public function position(): EmployeePosition
    {
        return $this->position;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function birthday(): DateTimeLiteral
    {
        return $this->birthday;
    }
}