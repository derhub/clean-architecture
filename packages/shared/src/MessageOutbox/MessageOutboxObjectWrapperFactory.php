<?php

namespace Derhub\Shared\MessageOutbox;

use Derhub\Shared\Message\Command\Command;
use Derhub\Shared\Message\Command\CommandListenerProvider;
use Derhub\Shared\Message\Event\Event;
use Derhub\Shared\Message\Event\EventListenerProvider;
use Derhub\Shared\Message\Message;
use Derhub\Shared\Message\Query\Query;
use Derhub\Shared\Message\Query\QueryListenerProvider;

class MessageOutboxObjectWrapperFactory implements MessageOutboxObjectWrapper
{
    public function __construct(
        private CommandListenerProvider $commandProvider,
        private QueryListenerProvider $queryProvider,
        private EventListenerProvider $eventProvider,
    ) {
    }

    public function create(Message $message): OutboxMessage
    {
        $messageType = $this->getMessageTypeFromObject($message);
        $name = $this->getNameFromMessage($message);
        return new OutboxMessage(
            OutboxMessageId::generate()->toString(),
            $messageType,
            $name,
            $message,
        );
    }

    private function getMessageTypeFromObject(Message $message): string
    {
        if ($message instanceof Event) {
            return 'event';
        }
        if ($message instanceof Command) {
            return 'command';
        }
        if ($message instanceof Query) {
            return 'query';
        }
    }

    private function getNameFromMessage(Message $message): string
    {
        if ($message instanceof Event) {
            return $this->eventProvider->getName($message::class);
        }
        if ($message instanceof Command) {
            return $this->commandProvider->getName($message::class);
        }
        if ($message instanceof Query) {
            return $this->queryProvider->getName($message::class);
        }
    }
}