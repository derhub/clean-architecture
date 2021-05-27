<?php

namespace Derhub\Business\Model\Event;

use Derhub\Business\Services\BaseMessage;
use Derhub\Shared\Model\DomainEvent;

final class BusinessNameChanged implements DomainEvent
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