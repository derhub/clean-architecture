<?php

namespace Derhub\Template\AggregateExample\Services\ChangeName;

use Derhub\Shared\Message\Command\Command;

class ChangeTemplateName implements Command
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
