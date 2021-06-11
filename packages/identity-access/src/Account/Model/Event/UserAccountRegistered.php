<?php

namespace Derhub\IdentityAccess\Account\Model\Event;

use Derhub\Shared\Model\DomainEvent;

class UserAccountRegistered implements DomainEvent
{
    private int $version = 1;

    public function __construct(
        private string $aggregateRootId,
        private string $email,
        private string $username,
        private array $roles,
    ) {
    }

    public function aggregateRootId(): string
    {
        return $this->aggregateRootId;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function username(): string
    {
        return $this->username;
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