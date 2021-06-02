<?php

namespace Derhub\BusinessManagement\Business\Model\Event;

use Derhub\Shared\Model\DomainEvent;

final class BusinessEnabled implements DomainEvent
{
    private int $version = 1;

    public function version(): int
    {
        return $this->version;
    }

    public function __construct(
        private string $aggregateRootId,
    ) {
    }

    public function aggregateRootId(): string
    {
        return $this->aggregateRootId;
    }
}
