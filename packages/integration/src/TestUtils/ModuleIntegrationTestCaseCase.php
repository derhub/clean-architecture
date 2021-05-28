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
        $requiredArrayKeys = ModuleInterface::SERVICES;

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

    private function testServiceMessageValue(
        string $name,
        array $service
    ): void {
        if (! in_array($name, ['commands', 'queries'])) {
            return;
        }

        foreach ($service as $className => $value) {
            self::assertTrue(
                class_exists($className),
                sprintf(
                    '%s %s not exist in module %s',
                    $name,
                    $className,
                    $this->getModule()->getId(),
                )
            );

            $handlers = $value;
            if (! is_array($handlers)) {
                $handlers = [$handlers];
            }

            foreach ($handlers as $handler) {
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
            $msgName = ($this->messageNameResolver)($className);
            $name = "{$module->getId()}.query.{$msgName}";
            self::assertTrue(
                $this->queryProvider->hasName(
                    "{$module->getId()}.query.{$msgName}"
                ),
                sprintf(
                    'query name `%s` not found',
                    $name
                )
            );
        }

        // test commands
        foreach ($serviceValues['commands'] as $className => $handler) {
            $msgName = ($this->messageNameResolver)($className);
            $name = "{$module->getId()}.command.{$msgName}";
            self::assertTrue(
                $this->commandProvider->hasName(
                    $name
                ),
                sprintf(
                    'command with name `%s` not found',
                    $name
                )
            );
        }

        // test events
        foreach ($serviceValues['events'] as $className) {
            $msgName = ($this->messageNameResolver)($className);
            $name = "{$module->getId()}.event.{$msgName}";
            self::assertTrue(
                $this->eventProvider->hasName(
                    $name
                ),
                sprintf(
                    'event with name `%s` not found',
                    $name
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