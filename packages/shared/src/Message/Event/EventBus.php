<?php

namespace Derhub\Shared\Message\Event;

use Derhub\Shared\Message\DispatcherInterface;

interface EventBus extends DispatcherInterface
{
    public function dispatch(object ...$messages): void;
}
