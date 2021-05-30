<?php

namespace Derhub\Integration\TestUtils;

use Derhub\Shared\ModuleInterface;

abstract class ModuleIntegrationTestCaseCase extends ModuleTestCase
{
    abstract protected function getModule(): ModuleInterface;

    public function test_module_id(): void
    {
        self::assertIsString($this->getModule()->getId());
    }

    public function test_module_service_values(): void
    {
        $services = $this->getModule()->services();
        $servicesNames = array_keys($services);
        $requiredArrayKeys = array_keys(ModuleInterface::INITIAL_SERVICES);

        foreach ($requiredArrayKeys as $name) {
            self::assertContains(
                $name,
                $servicesNames,
                'missing module '.$name
            );

            self::assertIsArray($services[$name]);
            $this->testServiceMessageValue($name, $services[$name]);
        }
    }

    private function testClassExist($name, array $classes): void
    {
        foreach ($classes as $className) {
            self::assertTrue(
                class_exists($className),
                sprintf(
                    '%s %s not exist in module %s',
                    $name,
                    $className,
                    $this->getModule()->getId(),
                )
            );
        }
    }

    private function testClassHandler($name, array $classes)
    {
        foreach ($classes as $handler) {
            self::assertTrue(
                class_exists($handler),
                sprintf(
                    '%s handler %s not exist in module %s',
                    $name,
                    $handler,
                    $this->getModule()->getId(),
                )
            );

            self::assertTrue(
                method_exists($handler, '__invoke'),
                sprintf(
                    'handler value is not callable %s %s.'
                    .'Missing __invoke method',
                    $name,
                    $this->getModule()->getId(),
                )
            );
        }
    }

    private function testServiceMessageValue(
        string $name,
        array $service
    ): void {
        if (! in_array(
            $name, [
            ModuleInterface::SERVICE_EVENTS,
            ModuleInterface::SERVICE_QUERIES,
            ModuleInterface::SERVICE_COMMANDS,
            ModuleInterface::SERVICE_LISTENERS,
        ],
            true
        )) {
            return;
        }

        if ($name === ModuleInterface::SERVICE_EVENTS) {
            $messages = array_values($service);
        } else {
            $messages = array_keys($service);
        }

        if ($name !== ModuleInterface::SERVICE_LISTENERS) {
            $this->testClassExist($name, $messages);
        }

        if ($name === ModuleInterface::SERVICE_EVENTS) {
            return;
        }

        $handlers = array_values($service);

        if ($name === ModuleInterface::SERVICE_LISTENERS) {
            $handlers = array_merge(...$handlers);
        }

        $this->testClassHandler($name, $handlers);
    }

    public function test_module_service_registry(): void
    {
        $module = $this->getModule();
        $this->moduleService->register($module);

        // check if module is registered
        self::assertTrue($this->moduleList->has($module->getId()));
        self::assertInstanceOf(
            $module::class,
            $this->moduleList->get($module->getId())
        );
        self::assertEquals(
            [$module->getId() => $module], $this->moduleList->all()
        );

        // test module register services
        $this->moduleService->start();
        self::assertTrue($this->moduleService->isStarted());


        $serviceValues = $module->services();
        // test query
        foreach ($serviceValues['queries'] as $className => $query) {
            $messageName = \Derhub\Shared\Capabilities\MessageName::forQuery(
                $this->getModule()->getId(),
                $className
            );
            self::assertTrue(
                $this->queryProvider->hasName($messageName),
                sprintf(
                    'query name `%s` not found',
                    $messageName
                )
            );
        }

        // test commands
        foreach ($serviceValues['commands'] as $className => $handler) {
            $messageName =
                \Derhub\Shared\Capabilities\MessageName::forCommand(
                    $this->getModule()->getId(), $className
                );
            self::assertTrue(
                $this->commandProvider->hasName(
                    $messageName
                ),
                sprintf(
                    'command with name `%s` not found',
                    $messageName
                )
            );
        }

        // test events
        foreach ($serviceValues['events'] as $className) {
            $messageName = \Derhub\Shared\Capabilities\MessageName::forEvent(
                $this->getModule()->getId(), $className
            );
            self::assertTrue(
                $this->eventProvider->hasName($messageName),
                sprintf(
                    'event with name `%s` not found',
                    $messageName
                )
            );
        }

        foreach ($serviceValues['listeners'] as $messageName => $listeners) {
            $className = $this->eventProvider->getClassName($messageName);
            $registeredListeners =
                $this->eventProvider->getListeners()[$className];

            self::assertEquals(
                $listeners,
                $registeredListeners,
                'failed to register listeners'
            );
        }
    }


}