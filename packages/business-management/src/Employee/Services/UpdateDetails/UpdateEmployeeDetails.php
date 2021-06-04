<?php

namespace Derhub\BusinessManagement\Employee\Services\UpdateDetails;

use Derhub\Shared\Message\Command\Command;

class UpdateEmployeeDetails implements Command
{
    private int $version = 1;

    public function __construct(
        private string $employeeId,
        private string $name,
        private string $initial,
        private string $position,
        private string $email,
        private string $birthday,
    ) {
    }

    public function employeeId(): string
    {
        return $this->employeeId;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function initial(): string
    {
        return $this->initial;
    }

    public function position(): string
    {
        return $this->position;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function birthday(): string
    {
        return $this->birthday;
    }

    public function version(): int
    {
        return $this->version;
    }
}