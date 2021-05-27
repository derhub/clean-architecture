<?php

namespace Derhub\Integration\TacticianBus\Locator;

use Derhub\Integration\UseListenerProviderHandlerRegistry;
use Derhub\Shared\Message\Event\EventListenerProvider;

class EventLocator extends ContainerLocator implements EventListenerProvider
{
    use UseListenerProviderHandlerRegistry;

    public function addHandler(
        string $name,
        string $message,
        mixed $handler,
    ): void {
        $this->addMultiHandler(
            $name,
            $message,
            $message,
            $handler
        );
    }

    public function getListenersForEvent(string $message): \Generator
    {
        $className = $this->nameLookup[$message] ?? $message;
        $handlerClasses = $this->handlers[$className] ?? null;
        if (! $handlerClasses) {
            return;
        }

        foreach ($handlerClasses as $class) {
            yield $this->resolveClass($class);
        }
    }

    public function addHandlerByName(string $name, mixed $handler): void
    {
        if (! $this->hasName($name)) {
            throw new \Exception('Unable to event add '.$name);
        }

        if (is_string($handler)) {
            $handler = [$handler];
        }

        $className = $this->getClassName($name);

        $this->handlers[$className] =
            array_merge($this->handlers[$className], $handler);
    }
}