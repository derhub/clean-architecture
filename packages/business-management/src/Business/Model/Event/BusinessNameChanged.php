<?php

namespace Derhub\BusinessManagement\Business\Model\Event;

use Derhub\Shared\Model\DomainEvent;

final class BusinessNameChanged implements DomainEvent
{
    private int $version = 1;

    public function __construct(
        private string $aggregateRootId,
        private string $name,
    ) {
    }

    public function aggregateRootId(): string
    {
        return $this->aggregateRootId;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function version(): int
    {
        return $this->version;
    }
}
