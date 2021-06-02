<?php

namespace Derhub\Integration\ModuleService;

use Derhub\Shared\Container\ContainerInterface;
use Derhub\Shared\Message\Command\CommandListenerProvider;
use Derhub\Shared\Message\Event\EventListenerProvider;
use Derhub\Shared\Message\ListenerProviderInterface;
use Derhub\Shared\Message\Query\QueryListenerProvider;
use Derhub\Shared\ModuleInterface;

class ModuleServiceImpl implements ModuleService
{
    private bool $isStarted;

    public function __construct(
        private ContainerInterface $container,
        private ModuleList $manager,
        private CommandListenerProvider $commandListener,
        private QueryListenerProvider $queryListener,
        private EventListenerProvider $eventListener,
    ) {
        $this->isStarted = false;
    }

    /**
     * @throws \Derhub\Integration\ModuleService\ModuleAlreadyRegistered
     */
    public function register(ModuleInterface ...$module): void
    {
        $this->manager->register(...$module);
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
        $binds = $module->services()[$module::DEPENDENCY_BIND] ?? [];

        foreach ($binds as $class => $abstract) {
            $this->container->bind($class, $abstract);
        }

        $binds = $services[$module::DEPENDENCY_SINGLETON] ?? [];

        foreach ($binds as $class => $abstract) {
            $this->container->singleton($class, $abstract);
        }
    }

    private function registerServices(ModuleInterface $module): void
    {
        $services = $module->services();

        $this->registerMessage(
            $this->commandListener,
            $module,
            $module::SERVICE_COMMANDS,
        );

        $this->registerMessage(
            $this->queryListener,
            $module,
            $module::SERVICE_QUERIES,
        );

        $this->registerMessage(
            $this->eventListener,
            $module,
            $module::SERVICE_EVENTS,
        );

        $this->registerListeners(
            $this->eventListener,
            $services[$module::SERVICE_LISTENERS] ?? [],
        );
    }

    private function registerMessage(
        ListenerProviderInterface $provider,
        ModuleInterface $module,
        string $messageType,
    ): void {
        $messages = $module->services()[$messageType] ?? [];
        foreach ($messages as $key => $value) {
            $className = null;
            $handler = [];
            if ($messageType === $module::SERVICE_EVENTS) {
                $className = $value;
            } elseif ($messageType === $module::SERVICE_COMMANDS
                || $messageType === $module::SERVICE_QUERIES) {
                $className = $key;
                $handler = $value;
            }

            if ($className === null) {
                continue;
            }

            $messageName =
                \Derhub\Shared\Capabilities\MessageName::for(
                    $module->getId(),
                    $messageType,
                    $className
                );

            $provider->addHandler(
                $messageName,
                $className,
                $handler
            );
        }
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
