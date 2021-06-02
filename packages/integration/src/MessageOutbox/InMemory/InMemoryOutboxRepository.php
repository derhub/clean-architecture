<?php

namespace Derhub\Integration\MessageOutbox\InMemory;

use Derhub\Shared\Message\Event\Event;
use Derhub\Shared\MessageOutbox\MessageOutboxWrapperFactory;
use Derhub\Shared\MessageOutbox\MessageSerializer;
use Derhub\Shared\MessageOutbox\OutboxMessage;
use Derhub\Shared\MessageOutbox\OutboxMessageConsumer;
use Derhub\Shared\MessageOutbox\OutboxMessageRecorder;
use Generator;

class InMemoryOutboxRepository implements
    OutboxMessageConsumer,
               OutboxMessageRecorder
{
    /**
     * @var array<\Derhub\Shared\MessageOutbox\OutboxMessage>
     */
    private array $messages;

    public function __construct(
        private MessageSerializer $serializer,
        private MessageOutboxWrapperFactory $factory
    ) {
        $this->messages = [];
    }

    public function recordFromEvent(Event ...$events): void
    {
        foreach ($events as $event) {
            $message = $this->factory->create($event);
            $this->messages[$message->id()] =
                $this->serializer->serialize($message);
        }
    }

    public function record(OutboxMessage ...$messages): void
    {
        foreach ($messages as $message) {
            $this->messages[$message->id()] =
                $this->serializer->serialize($message);
        }
    }

    /**
     * @return \Generator<\Derhub\Shared\MessageOutbox\OutboxMessage>
     */
    public function getUnConsumed(): Generator
    {
        foreach ($this->messages as $message) {
            $data = $this->serializer->unSerialize($message);

            if ($data->isConsume()) {
                continue;
            }

            yield $data;
        }
    }

    public function consume(OutboxMessage ...$messages): void
    {
        foreach ($messages as $message) {
            $id = $message->id();
            $this->messages[$id] =
                new OutboxMessage(
                    id: $id,
                    messageType: $message->messageType(),
                    name: $message->name(),
                    isConsume: true,
                    message: $message->message(),
                    meta: $message->meta()
                );
        }
    }

    public function eraseConsumedMessage(): void
    {
        foreach ($this->messages as $key => $message) {
            $data = $this->serializer->unSerialize($message);
            if ($data->isConsume()) {
                unset($this->messages[$key]);
            }
        }
    }
}
