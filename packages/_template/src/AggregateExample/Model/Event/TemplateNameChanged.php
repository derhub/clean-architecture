<?php

namespace Derhub\Template\AggregateExample\Model\Event;

class TemplateNameChanged implements \Derhub\Shared\Model\DomainEvent
{
    private int $version = 1;

    public function __construct(
        private string $aggregateRootId,
        private string $name,
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

    public function version(): int
    {
        return $this->version;
    }
}
