<?php

namespace Derhub\Shared\MessageOutbox;

use Derhub\Shared\Message\Message;

class OutboxMessage
{
    public function __construct(
        private string $id,
        private string $messageType,
        private string $name,
        private bool $isConsume,
        private Message $message,
        private array $meta = [],
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function isConsume(): bool
    {
        return $this->isConsume;
    }

    public function message(): Message
    {
        return $this->message;
    }

    public function messageType(): string
    {
        return $this->messageType;
    }

    public function meta(): array
    {
        return $this->meta;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function version(): int
    {
        return $this->message->version();
    }
}
