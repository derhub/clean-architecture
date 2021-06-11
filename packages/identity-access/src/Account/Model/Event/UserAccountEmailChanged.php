<?php

namespace Derhub\IdentityAccess\Account\Model\Event;

class UserAccountEmailChanged implements \Derhub\Shared\Model\DomainEvent
{
    private int $version = 1;

    public function __construct(
        private string $aggregateRootId,
        private string $email
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

    public function version(): int
    {
        return $this->version;
    }

}