<?php

namespace Derhub\Integration\TacticianBus;

use Derhub\Integration\MultipleMessageWrapper;
use Derhub\Shared\Message\Query\QueryBus;
use Derhub\Shared\Message\Query\QueryResponse;

class TacticianQueryBus extends BaseMessageBus implements QueryBus
{
    public function dispatch(object ...$messages): QueryResponse|array
    {
        if (isset($messages[1])) {
            return $this->handle(new MultipleMessageWrapper($messages));
        }

        return $this->handle($messages[0]);
    }
}
