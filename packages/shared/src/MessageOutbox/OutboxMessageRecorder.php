<?php

namespace Derhub\Shared\MessageOutbox;

use Derhub\Shared\Message\Event\Event;

interface OutboxMessageRecorder
{
    /**
     * @param \Derhub\Shared\Message\Event\Event ...$events
     *
     * @throws \Derhub\Shared\MessageOutbox\Exceptions\RecordMessageFailException
     */
    public function recordFromEvent(Event ...$events): void;

    /**
     * @param \Derhub\Shared\MessageOutbox\OutboxMessage ...$messages
     *
     * @throws \Derhub\Shared\MessageOutbox\Exceptions\RecordMessageFailException
     */
    public function record(OutboxMessage ...$messages): void;
}
