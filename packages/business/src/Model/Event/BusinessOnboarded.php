<?php

namespace Derhub\Business\Model\Event;

use Derhub\Shared\Model\DomainEvent;

final class BusinessOnboarded implements DomainEvent
{
    private int $version = 1;

    public function __construct(
        private string $aggregateRootId,
        private string $ownerId,
        private string $name,
        private string $slug,
        private string $createdAt,
        private string $country,
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

    public function createdAt(): string
    {
        return $this->createdAt;
    }

    public function ownerId(): string
    {
        return $this->ownerId;
    }

    public function version(): int
    {
        return $this->version;
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
