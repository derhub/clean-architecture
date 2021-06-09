<?php

namespace Derhub\Integration\ModuleService;

use Derhub\Shared\Container\ContainerInterface;
use Derhub\Shared\Message\Event\EventListenerProvider;
use Derhub\Shared\Message\MessageListenerProviderRegister;
use Derhub\Shared\Module\ModuleInterface;
use Derhub\Shared\Module\ModuleRegistry;

class ModuleServiceImpl implements ModuleService
{
    private bool $isStarted;

    public function __construct(
        private ContainerInterface $container,
        private ModuleRegistry $manager,
        private MessageListenerProviderRegister $listenerProvider
    ) {
        $this->isStarted = false;
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

    private function registerService(
        ModuleInterface $module,
        string $messageType,
    ): void {
        $messages = $module->services()[$messageType] ?? [];
        foreach ($messages as $className => $handlerOrEventClass) {
            if ($messageType === $module::SERVICE_COMMANDS) {
                $this->listenerProvider->command(
                    $module->getId(), $className, $handlerOrEventClass
                );
                continue;
            }

            if ($messageType === $module::SERVICE_QUERIES) {
                $this->listenerProvider->query(
                    $module->getId(), $className, $handlerOrEventClass
                );
            }

            if ($messageType === $module::SERVICE_EVENTS) {
                $this->listenerProvider->event(
                    $module->getId(), $handlerOrEventClass, []
                );
            }

            if ($messageType === $module::SERVICE_LISTENERS) {
                $this->listenerProvider->event(
                    $module->getId(), $className, $handlerOrEventClass
                );
            }
        }
    }

    private function registerServices(ModuleInterface $module): void
    {
        $this->registerService($module, $module::SERVICE_COMMANDS);
        $this->registerService($module, $module::SERVICE_QUERIES);
        $this->registerService($module, $module::SERVICE_EVENTS);
        $this->registerService($module, $module::SERVICE_LISTENERS);
    }

    /**
     * @inheritDoc
     */
    public function isStarted(): bool
    {
        return $this->isStarted;
    }

    public function list(): ModuleRegistry
    {
        return $this->manager;
    }

    public function register(ModuleInterface ...$module): void
    {
        $this->manager->register(...$module);
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
}
