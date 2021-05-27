<?php

namespace Derhub\Shared\Message;

interface ListenerProviderInterface
{
    /**
     * Register message and add handler
     * @param string $name
     * @param class-string $message
     * @param class-string|class-string[] $handler
     */
    public function addHandler(
        string $name,
        string $message,
        mixed $handler,
    ): void;

    public function addHandlerByName(string $name, mixed $handler): void;

    /**
     * @param array<class-string, array{name: string, handler: string|array}> $handlers
     */
    public function addHandlers(array $handlers): void;

    public function getListenersForEvent(string $message): mixed;

    /**
     * @return array<string, string[]>
     */
    public function getListeners(): array;

    /**
     * Return true if has name
     * @param string $name
     * @return bool
     */
    public function hasName(string $name): bool;

    /**
     * Return true if class object has handler
     * @param string $classStr
     * @return bool
     */
    public function hasHandler(string $classStr): bool;

    /**
     * Return class string by name
     * @param string $name
     * @return class-string|null
     */
    public function getClassName(string $name): ?string;

    /**
     * Return name by class string
     * @param string $className
     * @return string|null
     */
    public function getName(string $className): ?string;
}
