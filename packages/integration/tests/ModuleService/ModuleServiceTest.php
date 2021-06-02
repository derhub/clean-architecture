<?php

namespace Tests\Integration\ModuleService;

use Derhub\Integration\ModuleService\ModuleAlreadyRegistered;
use Derhub\Integration\TestUtils\ModuleIntegrationTestCaseCase;
use Derhub\Shared\ModuleInterface;
use Tests\Integration\Fixtures\MessageWithFactory\CmdMessageWithFactoryTest;
use Tests\Integration\Fixtures\TestModule;

class ModuleServiceTest extends ModuleIntegrationTestCaseCase
{
    protected function getModule(): ModuleInterface
    {
        return new TestModule();
    }
//
//    /**
//     * @test
//     */
//    public function it_register_service_when_modules_start(): void
//    {
//        $module = new TestModule();
//        $this->moduleService->register($module);
//        // check if module is registered
//        self::assertTrue($this->moduleList->has($module->getId()));
//        self::assertInstanceOf(
//            TestModule::class, $this->moduleList->get($module->getId())
//        );
//        self::assertEquals(
//            [$module->getId() => $module], $this->moduleList->all()
//        );
//
//        $this->moduleService->start();
//        self::assertTrue($this->moduleService->isStarted());
//
//        // test query
//        foreach ($module->getServices()['queries'] as $query) {
//            self::assertTrue(
//                $this->qLister->hasName(
//                    "{$module->getId()}.query.{$query['name']}"
//                )
//            );
//        }
//
//        // test commands
//        foreach ($module->getServices()['commands'] as $query) {
//            self::assertTrue(
//                $this->cmdLister->hasName(
//                    "{$module->getId()}.command.{$query['name']}"
//                )
//            );
//        }
//
//        // check if custom message factory is in assembler
//        self::assertTrue(
//            $this->assembler->has(CmdMessageWithFactoryTest::class)
//        );
//    }

    /**
     * @test
     */
    public function it_fails_to_register_module_twice(): void
    {
        $this->expectException(ModuleAlreadyRegistered::class);
        $module = new TestModule();
        $this->moduleService->register($module);
        $this->moduleService->register($module);
    }

    /**
     * @test
     */
    public function it_return_null_no_module(): void
    {
        self::assertNull($this->moduleList->get('test'));
    }
}
