<?php

namespace Derhub\Shared\Message\Event;

use Derhub\Shared\Message\DispatcherInterface;
use Derhub\Shared\MessageOutbox\OutboxMessage;

interface EventBus extends DispatcherInterface
{
    public function dispatch(object ...$messages): void;
}
