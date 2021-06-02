<?php

namespace Derhub\BusinessManagement\Business\Model\Event;

use Derhub\Shared\Model\DomainEvent;

class BusinessHanded implements DomainEvent
{
    private int $version = 1;

    public function version(): int
    {
        return $this->version;
    }

    public function __construct(
        private string $aggregateRootId,
        private string $ownerId,
        private string $name,
        private string $slug,
        private string $country,
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

    public function name(): string
    {
        return $this->name;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function country(): string
    {
        return $this->country;
    }
}