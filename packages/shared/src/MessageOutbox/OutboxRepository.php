<?php

namespace Derhub\Shared\MessageOutbox;

use Generator;

interface OutboxRepository
{
    /**
     * @param \Derhub\Shared\MessageOutbox\OutboxMessage ...$events
     *
     * @throws FailedToSaveMessageException
     */
    public function record(OutboxMessage ...$events): void;

    /**
     * @return Generator<OutboxMessage>
     *
     * @throws \Derhub\Shared\MessageOutbox\FailedToRetrieveMessageException
     */
    public function all(): Generator;

    public function markAsConsume(OutboxMessage ...$messages): void;

    public function eraseConsumed(): void;
}