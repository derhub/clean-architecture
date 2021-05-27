<?php

namespace Derhub\Business\Model\Event;

use Derhub\Shared\Model\DomainEvent;

class BusinessCountryChanged implements DomainEvent
{
    private int $version = 1;

    public function __construct(
        private ?string $aggregateRootId,
        private ?string $country
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

    public function country(): ?string
    {
        return $this->country;
    }

}