<?php

namespace Tests\Integration\Fixtures;

use Tests\Integration\Fixtures\Command\CommandMessageFixture;
use Tests\Integration\Fixtures\Command\CommandMessageFixtureHandler;
use Tests\Integration\Fixtures\Event\EventMessageFixture;
use Tests\Integration\Fixtures\Event\EventMessageFixtureHandlerOne;
use Tests\Integration\Fixtures\Event\EventMessageFixtureHandlerTwo;
use Tests\Integration\Fixtures\MessageWithFactory\CmdMessageWithFactoryHandler;
use Tests\Integration\Fixtures\MessageWithFactory\CmdMessageWithFactoryTest;
use Tests\Integration\Fixtures\Query\QueryMessageFixture;
use Tests\Integration\Fixtures\Query\QueryMessageFixtureHandler;

class TestModule extends \Derhub\Shared\AbstractModule
{
    public const ID = 'test_module';

    public function getId(): string
    {
        return self::ID;
    }

    public function services(): array
    {
        return [
            self::DEPENDENCY_BIND => [],
            self::DEPENDENCY_SINGLETON => [],
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
            'listeners' => [],
        ];
    }

    public function start(): void
    {
        $this->addEventListener(
            EventMessageFixture::class,
            [
                EventMessageFixtureHandlerOne::class,
                EventMessageFixtureHandlerTwo::class,
            ]
        );
    }
}
