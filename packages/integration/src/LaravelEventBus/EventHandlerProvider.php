<?php

namespace Derhub\Integration\LaravelEventBus;

use Derhub\Integration\AbstractListenerProvider;
use Derhub\Integration\MissingHandlerException;
use Derhub\Integration\UseListenerProviderHandlerRegistry;
use Derhub\Shared\Message\Event\EventListenerProvider;

use function class_exists;

class EventHandlerProvider extends AbstractListenerProvider implements EventListenerProvider
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

    /**
     * @param string $message
     * @return class-string|class-string[]
     * @throws \Derhub\Integration\MissingHandlerException
     */
    public function getListenersForEvent(string $message): array|string
    {
        if (class_exists($message) && $this->hasName($message)) {
            $className = $this->getName($message);
        } else {
            $className = $message;
        }

        return $this->handlers[$className] ??
            throw MissingHandlerException::forMessage($message);
    }
}
