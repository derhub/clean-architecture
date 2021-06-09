<?php

namespace Derhub\BusinessManagement\Business\Services\TransferOwnership;

use Derhub\BusinessManagement\Business\Services\BaseMessage;
use Derhub\Shared\Message\Command\Command;

class TransferBusinessOwnership extends BaseMessage implements Command
{
    private int $version = 1;

    public function __construct(
        private string $businessId,
        private string $ownerId,
    ) {
    }

    public function aggregateRootId(): string
    {
        return $this->businessId;
    }

    public function ownerId(): string
    {
        return $this->ownerId;
    }

    public function version(): int
    {
        return $this->version;
    }
}
