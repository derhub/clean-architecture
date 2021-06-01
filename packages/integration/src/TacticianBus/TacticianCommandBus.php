<?php

namespace Derhub\Integration\TacticianBus;

use Derhub\Integration\MultipleMessageWrapper;
use Derhub\Shared\Message\Command\CommandBus;
use Derhub\Shared\Message\Command\CommandResponse;

final class TacticianCommandBus extends BaseMessageBus implements CommandBus
{
    public function dispatch(object ...$messages): null|CommandResponse|array
    {
        if (isset($messages[1])) {
            return $this->handle(new MultipleMessageWrapper($messages));
        }

        return $this->handle($messages[0]);
    }
}
