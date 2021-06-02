<?php

namespace Tests\Shared;

use Derhub\Shared\AbstractModule;
use PHPUnit\Framework\TestCase;
use Tests\Shared\Fixtures\TestClass2;
use Tests\Shared\Fixtures\TestMessage;

class AbstractModuleTest extends TestCase
{
    /**
     * @var \Derhub\Shared\AbstractModule
     */
    private $module;

    protected function setUp(): void
    {
        parent::setUp();

        $this->module = new class() extends AbstractModule {
            public function getId(): string
            {
                return 'test';
            }

            public function start(): void
            {
                // TODO: Implement start() method.
            }
        };
    }

    /**
     * @test
     */
    public function it_can_convert_message_class_to_name(): void
    {
        self::assertEquals(
            'test.events.TestMessage',
            $this->module->eventName(\Tests\Shared\Fixtures\TestMessage::class)
        );

        self::assertEquals(
            'test.commands.TestMessage',
            $this->module->commandName(
                \Tests\Shared\Fixtures\TestMessage::class
            )
        );

        self::assertEquals(
            'test.queries.TestMessage',
            $this->module->queryName(
                \Tests\Shared\Fixtures\TestMessage::class
            )
        );
    }

    /**
     * @test
     */
    public function it_can_register_messages(): void
    {
        $this->module->addCommand(
            \Tests\Shared\Fixtures\TestMessage::class,
            \Tests\Shared\Fixtures\TestMessage::class
        );

        $this->module->addQuery(
            \Tests\Shared\Fixtures\TestMessage::class,
            \Tests\Shared\Fixtures\TestMessage::class
        );

        $this->module->addEvent(
            \Tests\Shared\Fixtures\TestMessage::class
        );
        $this->module->addEventListener(
            \Tests\Shared\Fixtures\TestMessage::class,
            [\Tests\Shared\Fixtures\TestMessage::class]
        );
        $this->module->addEvent(
            \Tests\Shared\Fixtures\TestMessage::class,
            \Tests\Shared\Fixtures\TestMessage::class
        );

        $services = $this->module->services();

        self::assertEquals(
            [
                'test.events.TestMessage' => [
                    \Tests\Shared\Fixtures\TestMessage::class,
                ],
            ],
            $services[\Derhub\Shared\ModuleInterface::SERVICE_LISTENERS]
        );

        self::assertEquals(
            [
                \Tests\Shared\Fixtures\TestMessage::class => \Tests\Shared\Fixtures\TestMessage::class,
            ],
            $services[\Derhub\Shared\ModuleInterface::SERVICE_COMMANDS]
        );

        self::assertEquals(
            [
                \Tests\Shared\Fixtures\TestMessage::class => \Tests\Shared\Fixtures\TestMessage::class,
            ],
            $services[\Derhub\Shared\ModuleInterface::SERVICE_QUERIES]
        );

        self::assertEquals(
            [
                \Tests\Shared\Fixtures\TestMessage::class => \Tests\Shared\Fixtures\TestMessage::class,
            ],
            $services[\Derhub\Shared\ModuleInterface::SERVICE_EVENTS]
        );
    }

    public function it_register_dependencies(): void
    {
        $this->module->addDependency(
            TestMessage::class,
            function () {
                return new \stdClass();
            }
        );

        $this->module->addDependency(
            TestClass2::class,
            TestMessage::class,
        );

        $this->module->addDependencySingleton(
            TestClass2::class,
            TestMessage::class,
        );

        $this->module->addDependencySingleton(
            TestMessage::class,
            function () {
                return new \stdClass();
            }
        );

        $services = $this->module->services();
        self::assertEquals(
            [
                TestMessage::class,
                function () {
                    return new \stdClass();
                },
                TestClass2::class,
                TestMessage::class,
            ],
            $services[\Derhub\Shared\ModuleInterface::DEPENDENCY_BIND]
        );

        self::assertEquals(
            [
                TestMessage::class,
                function () {
                    return new \stdClass();
                },
                TestClass2::class,
                TestMessage::class,
            ],
            $services[\Derhub\Shared\ModuleInterface::DEPENDENCY_SINGLETON]
        );
    }
}
