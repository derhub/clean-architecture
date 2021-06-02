<?php

namespace Derhub\Template\AggregateExample\Services\Publish;

use Derhub\Shared\Message\Command\Command;

class PublishTemplate implements Command
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
