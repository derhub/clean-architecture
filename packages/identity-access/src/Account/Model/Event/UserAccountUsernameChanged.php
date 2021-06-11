<?php

namespace Derhub\IdentityAccess\Account\Model\Event;

class UserAccountUsernameChanged implements \Derhub\Shared\Model\DomainEvent
{
    private int $version = 1;

    public function __construct(
        private string $aggregateRootId,
        private string $username
    ) {
    }

    public function aggregateRootId(): string
    {
        return $this->aggregateRootId;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function version(): int
    {
        return $this->version;
    }
}