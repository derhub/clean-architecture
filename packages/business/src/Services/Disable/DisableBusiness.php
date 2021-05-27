<?php

declare(strict_types=1);

namespace Derhub\Business\Services\Disable;

use Derhub\Business\Services\BaseMessage;
use Derhub\Shared\Message\Command\Command;

final class DisableBusiness extends BaseMessage implements Command
{
    public function __construct(private string $aggregateRootId)
    {
    }

    public function aggregateRootId(): string
    {
        return $this->aggregateRootId;
    }
}
