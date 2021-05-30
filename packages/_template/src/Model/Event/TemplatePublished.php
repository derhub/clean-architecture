<?php

namespace Derhub\Template\Model\Event;

class TemplatePublished implements \Derhub\Shared\Model\DomainEvent
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