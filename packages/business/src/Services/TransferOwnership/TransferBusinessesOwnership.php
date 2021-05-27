<?php

namespace Derhub\Business\Services\TransferOwnership;

use Derhub\Business\Services\BaseMessage;
use Derhub\Shared\Message\Command\Command;

class TransferBusinessesOwnership extends BaseMessage implements Command
{
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
