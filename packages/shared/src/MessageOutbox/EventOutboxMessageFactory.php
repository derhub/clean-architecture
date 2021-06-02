<?php

namespace Derhub\Shared\MessageOutbox;

use Derhub\Shared\Message\Event\Event;
use Derhub\Shared\Message\Event\EventListenerProvider;
use Derhub\Shared\Message\MessageTypes;

class EventOutboxMessageFactory implements MessageOutboxWrapperFactory
{
    public function __construct(
        private EventListenerProvider $eventProvider,
    ) {
    }

    public function create(Event $message): OutboxMessage
    {
        $name = $this->eventProvider->getName($message::class);
        return new OutboxMessage(
            id: OutboxMessageId::generate()->toString(),
            messageType: MessageTypes::EVENT,
            name: $name,
            isConsume: false,
            message: $message,
        );
    }
}
