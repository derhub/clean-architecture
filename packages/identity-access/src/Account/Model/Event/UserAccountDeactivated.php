<?php

namespace Derhub\IdentityAccess\Account\Model\Event;

use Derhub\Shared\Model\DomainEvent;

class UserAccountDeactivated implements DomainEvent
{
    private int $version = 1;

    public function __construct(
        private string $aggregateRootId,
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
}