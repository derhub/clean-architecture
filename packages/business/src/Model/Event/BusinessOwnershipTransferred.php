<?php

namespace Derhub\Business\Model\Event;

use Derhub\Business\Model\Values\BusinessId;
use Derhub\Business\Model\Values\OwnerId;
use Derhub\Shared\Model\AggregateRootId;
use Derhub\Shared\Model\DomainEvent;

class BusinessOwnershipTransferred implements DomainEvent
{
    private int $version = 1;

    public function version(): int
    {
        return $this->version;
    }

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

}