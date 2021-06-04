<?php

namespace Derhub\BusinessManagement\Employee\Model\Events;

use Derhub\Shared\Model\DomainEvent;

class EmployeeStatusChanged implements DomainEvent
{
    private int $version = 1;

    public function __construct(
        private ?string $aggregateRootId,
        private ?string $status,
    ) {
    }

    public function aggregateRootId(): string
    {
        return $this->aggregateRootId;
    }

    public function status(): ?string
    {
        return $this->status;
    }

    public function version(): int
    {
        return $this->version;
    }
}