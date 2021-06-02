<?php

namespace Derhub\Shared\MessageOutbox;

/**
 * Interface MessageConsumer
 * @package Derhub\Shared\MessageOutbox
 *
 * Mark outbox Message as consume
 */
interface OutboxMessageConsumer
{
    /**
     * @param \Derhub\Shared\MessageOutbox\OutboxMessage ...$message
     *
     * @throws \Derhub\Shared\MessageOutbox\Exceptions\FailedToConsume
     */
    public function consume(OutboxMessage ...$message): void;

    public function eraseConsumedMessage(): void;
    /**
     * @return iterable<OutboxMessage>
     *
     * @throws \Derhub\Shared\MessageOutbox\Exceptions\FailedToRetrieve
     */
    public function getUnConsumed(): iterable;
}
