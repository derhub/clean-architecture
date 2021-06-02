<?php

namespace Derhub\Shared\MessageOutbox;

/**
 * @template T
 */
interface MessageSerializer
{
    /**
     * @param \Derhub\Shared\MessageOutbox\OutboxMessage $message
     * @return T
     */
    public function serialize(OutboxMessage $message): mixed;

    /**
     * @param T $message
     * @return OutboxMessage
     */
    public function unSerialize(mixed $message): OutboxMessage;
}
