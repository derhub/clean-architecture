<?php

namespace Derhub\Integration\LaravelEventBus;

use Derhub\Shared\MessageOutbox\OutboxMessage;
use Derhub\Shared\MessageOutbox\OutboxRepository;

class ConsumeOutboxMessage
{
    public function __construct(private OutboxRepository $outbox)
    {
    }

    public function handle($job, $next): mixed
    {
        if ($job instanceof OutboxMessage) {
            $this->outbox->markAsConsume($job);
        }
        return $next($job);
    }
}