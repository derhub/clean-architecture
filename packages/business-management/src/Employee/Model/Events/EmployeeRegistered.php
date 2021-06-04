<?php

namespace Derhub\BusinessManagement\Employee\Model\Events;

use Derhub\Shared\Model\DomainEvent;

class EmployeeRegistered implements DomainEvent
{
    private int $version = 1;

    public function __construct(
        private string $employeeId,
        private string $employerId,
        private string $status,
        private ?string $name,
        private ?string $initial,
        private ?string $position,
        private ?string $email,
        private ?string $birthday,
    ) {
    }

    public function employeeId(): string
    {
        return $this->employeeId;
    }

    public function employerId(): string
    {
        return $this->employerId;
    }

    public function name(): ?string
    {
        return $this->name;
    }

    public function initial(): ?string
    {
        return $this->initial;
    }

    public function position(): ?string
    {
        return $this->position;
    }

    public function email(): ?string
    {
        return $this->email;
    }

    public function birthday(): ?string
    {
        return $this->birthday;
    }

    public function status(): ?string
    {
        return $this->status;
    }

    public function aggregateRootId(): string
    {
        return $this->employerId;
    }

    public function version(): int
    {
        return $this->version;
    }
}