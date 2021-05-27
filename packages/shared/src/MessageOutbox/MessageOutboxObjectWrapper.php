<?php

namespace Derhub\Shared\MessageOutbox;

use Derhub\Shared\Message\Message;

interface MessageOutboxObjectWrapper
{
    public function create(Message $message): OutboxMessage;
}