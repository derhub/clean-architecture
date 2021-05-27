<?php

namespace Tests\Integration\Fixtures;

use Derhub\Shared\ModuleInterface;
use Tests\Integration\Fixtures\Command\CommandMessageFixture;
use Tests\Integration\Fixtures\Command\CommandMessageFixtureHandler;
use Tests\Integration\Fixtures\Event\EventMessageFixture;
use Tests\Integration\Fixtures\Event\EventMessageFixtureHandlerOne;
use Tests\Integration\Fixtures\Event\EventMessageFixtureHandlerTwo;
use Tests\Integration\Fixtures\MessageWithFactory\CmdMessageWithFactoryHandler;
use Tests\Integration\Fixtures\MessageWithFactory\CmdMessageWithFactoryTest;
use Tests\Integration\Fixtures\MessageWithFactory\CmdMessageWithFactoryTestFactory;
use Tests\Integration\Fixtures\Query\QueryMessageFixture;
use Tests\Integration\Fixtures\Query\QueryMessageFixtureHandler;

class TestModule implements ModuleInterface
{

    public const ID = 'test_module';

    public function getId(): string
    {
        return self::ID;
    }

    public function getServices(): array
    {
        return [
            'commands' => [
                CommandMessageFixture::class => CommandMessageFixtureHandler::class,
                CmdMessageWithFactoryTest::class => CmdMessageWithFactoryHandler::class,
            ],
            'queries' => [
                QueryMessageFixture::class => QueryMessageFixtureHandler::class,
            ],
            'events' => [
                EventMessageFixture::class,
            ],
            'listeners' => [
                self::ID.'.event.EventMessageFixture' => [
                    EventMessageFixtureHandlerOne::class,
                    EventMessageFixtureHandlerTwo::class,
                ],
            ],
        ];
    }

    public function start(): void
    {
    }
}