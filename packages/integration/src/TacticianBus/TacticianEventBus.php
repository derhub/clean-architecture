<?php

namespace Derhub\Integration\TacticianBus;

use Derhub\Integration\MultipleMessageWrapper;
use Derhub\Shared\Message\Event\EventBus;

class TacticianEventBus extends BaseMessageBus implements EventBus
{
    public function dispatch(object ...$messages): void
    {
        $this->handle(new MultipleMessageWrapper($messages));
    }
}
