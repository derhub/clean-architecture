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
     * @return iterable<OutboxMessage>
     *
     * @throws \Derhub\Shared\MessageOutbox\Exceptions\FailedToRetrieve
     */
    public function getUnConsumed(): iterable;

    public function eraseConsumedMessage(): void;

    /**
     * @param \Derhub\Shared\MessageOutbox\OutboxMessage ...$message
     *
     * @throws \Derhub\Shared\MessageOutbox\Exceptions\FailedToConsume
     */
    public function consume(OutboxMessage ...$message): void;
}