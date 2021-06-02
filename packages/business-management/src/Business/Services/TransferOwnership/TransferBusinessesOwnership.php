<?php

namespace Derhub\BusinessManagement\Business\Services\TransferOwnership;

use Derhub\BusinessManagement\Business\Services\BaseMessage;
use Derhub\Shared\Message\Command\Command;

class TransferBusinessesOwnership extends BaseMessage implements Command
{
    private int $version = 1;

    public function version(): int
    {
        return $this->version;
    }

    public function __construct(
        private string $aggregateRootId,
        private string $ownerId,
    ) {
    }

    public function aggregateRootId(): string
    {
        return $this->aggregateRootId;
    }

    public function ownerId(): string
    {
        return $this->ownerId;
    }
}
