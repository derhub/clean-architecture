<?php

declare(strict_types=1);

namespace Derhub\Template\AggregateExample\Services\Restore;

use Derhub\Shared\Message\Event\Event;

final class RestoreTemplate implements Event
{
    private int $version = 1;

    public function __construct(private string $aggregateRootId)
    {
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
