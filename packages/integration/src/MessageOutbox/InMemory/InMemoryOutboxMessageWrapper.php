<?php

namespace Derhub\Integration\MessageOutbox\InMemory;


use Derhub\Shared\Message\Event\Event;
use Derhub\Shared\Message\MessageTypes;
use Derhub\Shared\MessageOutbox\OutboxMessage;
use Derhub\Shared\MessageOutbox\OutboxMessageId;

class InMemoryOutboxMessageWrapper
    implements \Derhub\Shared\MessageOutbox\MessageOutboxWrapperFactory
{
    public function create(Event $message): OutboxMessage
    {
        return new OutboxMessage(
            id: OutboxMessageId::generate()->toString(),
            messageType: MessageTypes::EVENT,
            name: $message::class,
            isConsume: false,
            message: $message,
        );
    }
}
