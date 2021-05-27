<?php

namespace Derhub\Integration;

trait UseListenerProviderHandlerRegistry
{
    protected function registerLookups(
        string $name,
        string $message,
    ): void {
        $this->nameLookup[$name] = $message;
        $this->classLookup[$message] = $name;
    }

    protected function registerMultipleHandler($key, array $handler): void
    {
        if (isset($this->handlers[$key])) {
            $this->handlers[$key] =
                array_merge($this->handlers[$key], $handler);
        } else {
            $this->handlers[$key] = $handler;
        }
    }

    protected function registerSingleHandler($key, string $handler): void
    {
        if (isset($this->handlers[$key])) {
            $this->handlers[$key] =
                array_merge($this->handlers[$key], $handler);
        } else {
            $this->handlers[$key] = $handler;
        }
    }

    protected function addSingleHandler(
        string $name,
        string $message,
        string $handlerKey,
        mixed $handler,
    ): void {
        $this->registerLookups(
            $name,
            $message
        );
        $this->registerSingleHandler($handlerKey, $handler);
    }

    protected function addMultiHandler(
        string $name,
        string $message,
        string $handlerKey,
        mixed $handler
    ): void {
        $this->registerLookups(
            $name,
            $message
        );

        $this->registerMultipleHandler($handlerKey, $handler ?? []);
    }
}