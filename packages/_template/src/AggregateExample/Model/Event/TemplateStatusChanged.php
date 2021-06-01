<?php

namespace Derhub\Template\AggregateExample\Model\Event;

class TemplateStatusChanged implements \Derhub\Shared\Model\DomainEvent
{
    private int $version = 1;

    public function __construct(
        private string $aggregateRootId,
        private string $status,
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

    public function status(): string
    {
        return $this->status;
    }

}