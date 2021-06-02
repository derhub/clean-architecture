<?php

namespace Derhub\Shared\MessageOutbox;

/**
 * Interface OutboxMessageRelay
 * @package Derhub\Shared\MessageOutbox
 *
 * pull the unconsumed recorded OutboxMessage then publish it using EventBus
 */
interface OutboxMessageRelay
{
    public function publish(): void;
}
