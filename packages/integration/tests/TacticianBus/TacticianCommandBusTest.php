<?php

namespace Tests\Integration\TacticianBus;

use Tests\Integration\Fixtures\Command\CommandMessageFixture;
use Tests\Integration\Fixtures\Command\CommandMessageFixtureHandler;
use Tests\Integration\Fixtures\Command\CommandMessageFixtureResponse;
use Tests\Integration\Fixtures\SimpleValueObjFixture;
use Tests\Integration\TestCase;

class TacticianCommandBusTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->container->add(
            CommandMessageFixtureHandler::class,
            static fn () => new CommandMessageFixtureHandler(),
        );
    }

    /**
     * @test
     */
    public function it_can_dispatch_multiple_message(): void
    {
        ['bus' => $bus, 'listener' => $locator] = $this->createCommandBus();
        $msg = new CommandMessageFixture(
            SimpleValueObjFixture::fromString('tst'),
            'test'
        );


        $locator->addHandler(
            'CommandFixture',
            CommandMessageFixture::class,
            CommandMessageFixtureHandler::class
        );


        $results = $bus->dispatch($msg, $msg);

        self::assertIsArray($results);
        foreach ($results as $result) {
            self::assertInstanceOf(
                CommandMessageFixtureResponse::class,
                $result
            );
        }
    }

    /**
     * @test
     */
    public function it_dispatch_command_message(): void
    {
        ['bus' => $bus, 'listener' => $locator] = $this->createCommandBus();
        $msg = new CommandMessageFixture(
            SimpleValueObjFixture::fromString('tst'),
            'test'
        );


        $locator->addHandler(
            'CommandFixture',
            CommandMessageFixture::class,
            CommandMessageFixtureHandler::class
        );

        $result = $bus->dispatch($msg);

        self::assertInstanceOf(CommandMessageFixtureResponse::class, $result);
    }
}
