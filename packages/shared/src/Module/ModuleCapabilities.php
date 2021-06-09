<?php

namespace Derhub\Shared\Module;

use Derhub\Shared\Message\MessageName;
use Derhub\Shared\Module\ModuleInterface as MI;

trait ModuleCapabilities
{
    protected static array $services = MI::INITIAL_SERVICES;

    /**
     * @param class-string<\Derhub\Shared\Message\Command\Command> $class
     * @param string $handlerClass
     * @return $this
     */
    public function addCommand(string $class, string $handlerClass): static
    {
        self::$services[MI::SERVICE_COMMANDS][$class] =
            $handlerClass;

        return $this;
    }

    public function addDependency(
        string $class,
        string|callable $abstract,
    ): static {
        self::$services[MI::DEPENDENCY_BIND][$class] = $abstract;

        return $this;
    }

    public function addDependencySingleton(
        string $class,
        string|callable $abstract,
    ): static {
        self::$services[MI::DEPENDENCY_SINGLETON][$class] =
            $abstract;

        return $this;
    }

    /**
     * Register event and listener
     * @param class-string<\Derhub\Shared\Message\Event\Event> ...$classes
     * @return $this
     */
    public function addEvent(string ...$classes): static
    {
        foreach ($classes as $events) {
            self::$services[MI::SERVICE_EVENTS][$events] = $events;
        }

        return $this;
    }

    /**
     * Register Event Listener
     * @param class-string<\Derhub\Shared\Message\Event\Event>|string $classOrName
     * @param array $handlerClass
     * @return $this
     */
    public function addEventListener(
        string $classOrName,
        array $handlerClass
    ): static {
        $messageName = $classOrName;
        if (class_exists($classOrName)) {
            $messageName = $this->eventName($classOrName);
        }

        self::$services[MI::SERVICE_LISTENERS][$messageName] ??= [];
        self::$services[MI::SERVICE_LISTENERS][$messageName] =
            array_merge(
                self::$services[MI::SERVICE_LISTENERS][$messageName],
                $handlerClass
            );

        return $this;
    }

    /**
     * @param class-string<\Derhub\Shared\Message\Query\Query> $class
     * @param string $handlerClass
     * @return $this
     */
    public function addQuery(string $class, string $handlerClass): static
    {
        self::$services[MI::SERVICE_QUERIES][$class] =
            $handlerClass;

        return $this;
    }

    public function commandName(string $class): string
    {
        return MessageName::forCommand($this->getId(), $class);
    }

    public function eventName(string $class): string
    {
        return MessageName::forEvent($this->getId(), $class);
    }

    abstract public function getId(): string;

    public function queryName(string $class): string
    {
        return MessageName::forQuery($this->getId(), $class);
    }

    public function services(): array
    {
        return self::$services;
    }
}
