<?php

namespace Derhub\Shared\MessageOutbox;

class SimpleSerializer implements MessageSerializer
{

    public function serialize(OutboxMessage $message): string
    {
        return serialize($message);
    }

    public function unSerialize(mixed $message): OutboxMessage
    {
        return unserialize($message);
    }
}