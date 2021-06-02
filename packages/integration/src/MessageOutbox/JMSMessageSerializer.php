<?php

namespace Derhub\Integration\MessageOutbox;

use Derhub\Shared\Message\Command\CommandListenerProvider;
use Derhub\Shared\Message\Event\EventListenerProvider;
use Derhub\Shared\Message\Query\QueryListenerProvider;
use Derhub\Shared\MessageOutbox\MessageSerializer;
use Derhub\Shared\MessageOutbox\OutboxMessage;
use Derhub\Shared\Values\DateTimeLiteral;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerInterface;

/**
 * @template-implements MessageSerializer<string>
 */
class JMSMessageSerializer implements MessageSerializer
{
    public const SERIALIZER_ID = 'jms_serializer';

    /**
     * JMSMessageSerializer constructor.
     * @param \Derhub\Shared\Message\Command\CommandListenerProvider $commandProvider
     * @param \Derhub\Shared\Message\Query\QueryListenerProvider $queryProvider
     * @param \Derhub\Shared\Message\Event\EventListenerProvider $eventProvider
     * @param Serializer $jmsSerializer
     */
    public function __construct(
        private CommandListenerProvider $commandProvider,
        private QueryListenerProvider $queryProvider,
        private EventListenerProvider $eventProvider,
        private SerializerInterface $jmsSerializer,
    ) {
    }

    public function serialize(OutboxMessage $message): array
    {
        $messageArr = $this->jmsSerializer
            ->toArray($message->message())
        ;

        return [
            'id' => $message->id(),
            'name' => $message->name(),
            'version' => $message->version(),
            'message_type' => $message->messageType(),
            'message' => $messageArr,
            'meta' => [
                'created_at' => DateTimeLiteral::now()->toString(),
                'serializer' => self::SERIALIZER_ID,
            ],
        ];
    }

    public function unSerialize(mixed $message): OutboxMessage
    {
        $msgType = $message['message_type'];
        $name = $message['name'];
        $messageCLass = match ($msgType) {
            'event' => $this->eventProvider->getClassName($name),
            'command' => $this->commandProvider->getClassName($name),
            'query' => $this->queryProvider->getClassName($name),
        };

        $messageObj = $this->jmsSerializer
            ->fromArray($message['message'], $messageCLass)
        ;
        return new OutboxMessage(
            id: $message['id'],
            messageType: $msgType,
            name: $message['name'],
            message: $messageObj,
            meta: $message['meta'],
        );
    }
}
