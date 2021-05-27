<?php

namespace Derhub\Integration\LaravelEventBus\Locator;

use Derhub\Integration\AbstractListenerProvider;
use Derhub\Integration\MissingHandlerException;

abstract class BaseListenerProvider extends AbstractListenerProvider
{
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