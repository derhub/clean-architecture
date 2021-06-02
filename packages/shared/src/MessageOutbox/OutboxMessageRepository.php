<?php

namespace Derhub\Shared\MessageOutbox;

interface OutboxMessageRepository
    extends OutboxMessageConsumer, OutboxMessageRecorder
{
}