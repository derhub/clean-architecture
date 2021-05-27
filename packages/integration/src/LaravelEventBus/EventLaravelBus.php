<?php

namespace Derhub\Integration\LaravelEventBus;

use Derhub\Shared\Message\Event\Event;
use Derhub\Shared\Message\Event\EventBus;
use Derhub\Shared\Message\Event\EventListenerProvider;
use Derhub\Shared\MessageOutbox\OutboxMessage;
use Illuminate\Database\Eloquent\Model;

final class EventLaravelBus implements EventBus
{
    public function __construct(
        private EventListenerProvider $provider
    ) {
    }

    public function dispatch(object ...$messages): void
    {
        foreach ($messages as $message) {
            $this->handle($message);
        }
    }

    private function handle(object $object): void
    {
        $message = $object;
        if ($object instanceof OutboxMessage) {
            $messageName = $object->name();
            $message = $object->message();
        } else {
            $className = $object::class;
            $messageName = $this->provider->getName($className);
        }

        $handlers = $this->provider->getListenersForEvent($messageName);

        if (is_iterable($handlers)) {
            foreach ($handlers as $handler) {
                $this->handleSingle($handler, $messageName, $message);
            }
        } else {
            $this->handleSingle($handlers, $messageName, $message);
        }
    }

    private function handleSingle(
        string $handler,
        string $messageName,
        object $message
    ): void {
        \Bus::dispatch(
            new EventConsumer($handler, $messageName, $message)
        );
    }
}