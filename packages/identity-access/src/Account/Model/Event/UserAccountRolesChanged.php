<?php

namespace Derhub\IdentityAccess\Account\Model\Event;

class UserAccountRolesChanged implements \Derhub\Shared\Model\DomainEvent
{
    private int $version = 1;

    public function __construct(
        private string $aggregateRootId,
        private array $roles
    ) {
    }

    public function aggregateRootId(): string
    {
        return $this->aggregateRootId;
    }

    public function roles(): array
    {
        return $this->roles;
    }

    public function version(): int
    {
        return $this->version;
    }
}