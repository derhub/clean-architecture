<?php

namespace Derhub\Integration;

use Derhub\Shared\Container\ContainerInterface;
use Derhub\Shared\Message\ListenerProviderInterface;

abstract class AbstractListenerProvider implements ListenerProviderInterface
{
    /**
     * @var array<string, mixed>
     */
    protected array $handlers = [];
    /**
     * @var array<class-string, string>
     */
    protected array $nameLookup = [];
    /**
     * @var array<string, class-string>
     */
    protected array $classLookup = [];

    public function __construct(
        protected ContainerInterface $container,
    ) {
    }

    public function addHandler(
        string $name,
        string $message,
        mixed $handler,
    ): void {
        $this->nameLookup[$message] = $name;
        $this->classLookup[$name] = $message;
        $this->handlers[$message] = $handler;
    }

    public function addHandlerByName(string $name, mixed $handler): void
    {
        if (! $this->hasName($name)) {
            $this->nameLookup[$name] = NameOnlyMessage::class;
        }

        $this->handlers[$name] = $handler;
    }

    public function addHandlers(array $handlers): void
    {
        foreach ($handlers as $handler) {
            $this->addHandler(
                name: $handler['name'],
                message: $handler['message'],
                handler: $handler['handler']
            );
        }
    }

    public function getListenersForEvent(string $message): mixed
    {
        $className = $this->nameLookup[$message] ?? $message;
        $handlerClass = $this->handlers[$className] ??
            throw MissingHandlerException::forMessage($message);

        return $this->container->resolve($handlerClass);
    }


    public function getListeners(): array
    {
        return $this->handlers;
    }

    public function hasName(string $name): bool
    {
        return isset($this->nameLookup[$name]);
    }

    public function hasHandler(string $classStr): bool
    {
        return isset($this->handlers[$classStr]);
    }

    public function getClassName(string $name): ?string
    {
        return $this->nameLookup[$name] ?? null;
    }

    public function getName(string $className): ?string
    {
        return $this->classLookup[$className] ?? null;
    }
}
