<?php

namespace Derhub\Integration\TacticianBus\Handlers;

use Derhub\Integration\MultipleMessageWrapper;

class MultipleMessageHandler extends AbstractMessageHandler
{
    public function execute($command, callable $next)
    {
        if (! ($command instanceof MultipleMessageWrapper)) {
            return $this->handleMessage($command);
        }

        $results = [];
        foreach ($command->messages() as $message) {
            $results[] = $this->handleMessage($message);
        }

        return $results;
    }
}
