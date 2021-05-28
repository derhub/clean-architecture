<?php

namespace Derhub\Integration\ModuleService;

use Derhub\Integration\MessageType;
use Derhub\Shared\Container\ContainerInterface;
use Derhub\Shared\Message\Command\CommandListenerProvider;
use Derhub\Shared\Message\Event\EventListenerProvider;
use Derhub\Shared\Message\ListenerProviderInterface;
use Derhub\Shared\Message\Query\QueryListenerProvider;
use Derhub\Shared\ModuleInterface;

class ModuleServiceImpl implements ModuleService
{
    private bool $isStarted;
    private MessageNameResolver $messageNameResolver;

    public function __construct(
        private ContainerInterface $container,
        private ModuleList $manager,
        private CommandListenerProvider $commandListener,
        private QueryListenerProvider $queryListener,
        private EventListenerProvider $eventListener,
    ) {
        $this->isStarted = false;
        $this->messageNameResolver = new MessageNameResolver();
    }

    /**
     * @throws \Derhub\Integration\ModuleService\ModuleAlreadyRegistered
     */
    public function register(ModuleInterface $module): void
    {
        $this->manager->register($module);
    }

    /**
     * @inheritDoc
     */
    public function isStarted(): bool
    {
        return $this->isStarted;
    }

    public function list(): ModuleList
    {
        return $this->manager;
    }

    /**
     * @inheritDoc
     */
    public function start(): void
    {
        if ($this->isStarted()) {
            return;
        }

        foreach ($this->manager->all() as $module) {
            $module->start();
            $this->registerDependencies($module);
            $this->registerServices($module);
        }

        //TODO: register role & permission

        $this->isStarted = true;
    }

    private function registerDependencies(ModuleInterface $module): void
    {
        $services = $module->services();
        $binds = $services[$module::DEPENDENCY_BIND];

        foreach ($binds as $class => $abstract) {
            $this->container->bind($class, $abstract);
        }

        $binds = $services[$module::DEPENDENCY_SINGLETON];

        foreach ($binds as $class => $abstract) {
            $this->container->singleton($class, $abstract);
        }
    }

    private function registerServices(ModuleInterface $module): void
    {
        $services = $module->services();

        $this->registerMessage(
            $this->commandListener,
            $module->getId(),
            MessageType::COMMAND,
            $services[$module::SERVICE_COMMANDS],
        );

        $this->registerMessage(
            $this->queryListener,
            $module->getId(),
            MessageType::QUERY,
            $services[$module::SERVICE_QUERIES],
        );

        $this->registerMessage(
            $this->eventListener,
            $module->getId(),
            MessageType::EVENT,
            $services[$module::SERVICE_EVENTS],
        );

        $this->registerListeners(
            $this->eventListener,
            $services[$module::SERVICE_LISTENERS],
        );
    }

    private function registerMessage(
        ListenerProviderInterface $provider,
        string $moduleName,
        string $messageType,
        array $messages,
    ): void {
        foreach ($messages as $key => $value) {
            $className = null;
            $handler = [];
            if ($messageType === MessageType::EVENT) {
                $className = $value;
            } elseif ($messageType === MessageType::COMMAND
                || $messageType === MessageType::QUERY) {
                $className = $key;
                $handler = $value;
            }

            if ($className === null) {
                continue;
            }

            $messageName = $this->getMessageNameFromClassName($className);
            $name =
                "{$moduleName}.{$messageType}.{$messageName}";

            $provider->addHandler(
                $name,
                $className,
                $handler
            );
        }
    }

    public function getMessageNameFromClassName(string $messageClass): string
    {
        return ($this->messageNameResolver)($messageClass);
    }

    private function registerListeners(
        EventListenerProvider $eventListener,
        mixed $listeners
    ): void {
        foreach ($listeners as $name => $listener) {
            $eventListener->addHandlerByName($name, $listener);
        }
    }
}