<?php

declare(strict_types=1);

namespace Derhub\BusinessManagement\Business\Services\Disable;

use Derhub\Shared\Message\Command\Command;

final class DisableBusiness implements Command
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
