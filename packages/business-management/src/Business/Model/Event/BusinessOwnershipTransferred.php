<?php

namespace Derhub\BusinessManagement\Business\Model\Event;

use Derhub\BusinessManagement\Business\Model\Values\OwnerId;
use Derhub\Shared\Model\AggregateRootId;
use Derhub\Shared\Model\DomainEvent;

class BusinessOwnershipTransferred implements DomainEvent
{
    private int $version = 1;

    public function __construct(
        private string $aggregateRootId,
        private string $ownerId,
    ) {
    }

    public function aggregateRootId(): string
    {
        return $this->aggregateRootId;
    }

    public function ownerId(): string
    {
        return $this->ownerId;
    }

    public function version(): int
    {
        return $this->version;
    }
}
