<?php

namespace Derhub\Business\Services\HandOver;

use Derhub\Business\Services\BaseMessage;
use Derhub\Shared\Message\Command\Command;

class HandOverBusiness extends BaseMessage implements Command
{
    public function __construct(
        private string $aggregateRootId
    ) {
    }

    public function aggregateRootId(): string
    {
        return $this->aggregateRootId;
    }
}
