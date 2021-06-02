<?php

declare(strict_types=1);

namespace Derhub\Shared\MessageOutbox;

use Derhub\Shared\Message\Message;

/**
 * Interface MessageProcessor
 * @package Derhub\Shared\MessageOutbox
 *
 * Mark message as process
 */
interface OutboxMessageProcessor
{
    public function isProcess(OutboxMessage $event): bool;

    /**
     * @param \Derhub\Shared\MessageOutbox\OutboxMessage ...$event
     *
     * @throws \Derhub\Shared\MessageOutbox\Exceptions\FailedToProcessMessage
     * @throws \Derhub\Shared\MessageOutbox\Exceptions\MessageAlreadyProcess
     */
    public function process(OutboxMessage ...$event): void;
}