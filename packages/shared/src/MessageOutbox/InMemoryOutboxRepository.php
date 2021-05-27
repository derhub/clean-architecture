<?php

namespace Derhub\Shared\MessageOutbox;

use Generator;

class InMemoryOutboxRepository implements OutboxRepository
{
    /**
     * @var array<\Derhub\Shared\MessageOutbox\OutboxMessage>
     */
    private array $messages;

    public function __construct(private MessageSerializer $serializer)
    {
        $this->messages = [];
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
    public function all(): Generator
    {
        foreach ($this->messages as $message) {
            yield $this->serializer->unSerialize($message);
        }
    }

    public function markAsConsume(OutboxMessage ...$messages): void
    {
        foreach ($messages as $message) {
            $id = $message->id();
            $this->messages[$id] =
                new OutboxMessage(
                    $id,
                    $message->messageType(),
                    $message->name(),
                    $message->message(),
                    array_merge($message->meta(), ['consumed' => true])
                );
        }
    }

    public function eraseConsumed(): void
    {
        foreach ($this->messages as $key => $message) {
            $isConsumed = $message->meta()['consumed'] ?? false;
            if ($isConsumed) {
                unset($this->messages[$key]);
            }
        }
    }
}