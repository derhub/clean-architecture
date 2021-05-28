<?php

namespace EB\Template\Services\SampleCommand;

use EB\Shared\Message\Command\Command;

class SampleCommand implements Command
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