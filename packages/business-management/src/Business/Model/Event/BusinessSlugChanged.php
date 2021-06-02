<?php

namespace Derhub\BusinessManagement\Business\Model\Event;

use Derhub\BusinessManagement\Business\Model\Values\Slug;

class BusinessSlugChanged implements \Derhub\Shared\Model\DomainEvent
{
    protected int $version = 1;

    public function __construct(
        private string $aggregateRootId,
        private string $slug
    ) {
    }

    public function aggregateRootId(): string
    {
        return $this->aggregateRootId;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function version(): int
    {
        return $this->version;
    }
}
