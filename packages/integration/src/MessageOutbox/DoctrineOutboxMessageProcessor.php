<?php

namespace Derhub\Integration\MessageOutbox;

use Derhub\Shared\MessageOutbox\OutboxMessage;
use Derhub\Shared\MessageOutbox\OutboxMessageProcessor;

class DoctrineOutboxMessageProcessor implements OutboxMessageProcessor
{
    public function isProcess(OutboxMessage $event): bool
    {
        // TODO: Implement isProcess() method.
    }

    public function process(OutboxMessage ...$event): void
    {
        // TODO: Implement process() method.
    }
}
