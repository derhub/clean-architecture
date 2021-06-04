<?php

namespace Derhub\BusinessManagement\Employee\Model\Events;

use Derhub\Shared\Model\DomainEvent;

class EmployeeInformationUpdated implements DomainEvent
{
    private int $version = 1;

    public function __construct(
        private string $aggregateRootId,
        private string $name,
        private string $position,
        private string $email,
        private string $birthday
    ) {
    }

    public function aggregateRootId(): string
    {
        return $this->aggregateRootId;
    }

    public function version(): int
    {
        return $this->version;
    }

    public function name(): string
    {
        return $this->name;
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

}