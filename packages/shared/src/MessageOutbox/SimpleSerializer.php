<?php

namespace Derhub\Shared\MessageOutbox;

/**
 * Class SimpleSerializer
 * @package Derhub\Shared\MessageOutbox
 *
 * @template-implements MessageSerializer<string>
 */
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