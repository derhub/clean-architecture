<?php

namespace Derhub\BusinessManagement\Business\Model\Event;

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

    public function country(): ?string
    {
        return $this->country;
    }

    public function version(): int
    {
        return $this->version;
    }
}
