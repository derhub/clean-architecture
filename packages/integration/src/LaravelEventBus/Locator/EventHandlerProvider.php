<?php

namespace Derhub\Integration\LaravelEventBus\Locator;

use Derhub\Integration\UseListenerProviderHandlerRegistry;
use Derhub\Shared\Message\Event\EventListenerProvider;

class EventHandlerProvider extends BaseListenerProvider
    implements EventListenerProvider
{
    use UseListenerProviderHandlerRegistry;

    public function addHandler(
        string $name,
        string $message,
        mixed $handler,
    ): void {
        $this->addMultiHandler(
            name: $name,
            message: $message,
            handlerKey: $name,
            handler: $handler,
        );
    }
}