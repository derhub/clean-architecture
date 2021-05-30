<?php

namespace Derhub\Template\Model\Event;

use Derhub\Shared\Model\DomainEvent;

class TemplateRestored implements DomainEvent
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