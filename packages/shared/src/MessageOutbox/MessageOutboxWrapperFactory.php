<?php

namespace Derhub\Shared\MessageOutbox;

use Derhub\Shared\Message\Event\Event;

interface MessageOutboxWrapperFactory
{
    public function create(Event $message): OutboxMessage;
}
