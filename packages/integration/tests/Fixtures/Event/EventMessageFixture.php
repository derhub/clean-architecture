<?php

namespace Tests\Integration\Fixtures\Event;

use Derhub\Shared\Message\Event\Event;
use Derhub\Shared\Utils\Uuid;

class EventMessageFixture implements Event
{
    private int $version = 1;

    public function __construct(
        private string $value
    ) {
    }

    public function aggregateRootId(): ?string
    {
        return Uuid::generate()->toString();
    }

    public function version(): int
    {
        return $this->version;
    }

    public function value(): string
    {
        return $this->value;
    }
}