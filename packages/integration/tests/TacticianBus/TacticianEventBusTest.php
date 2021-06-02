<?php

namespace Tests\Integration\TacticianBus;

use Derhub\Integration\TestUtils\ModuleTestCase;
use Tests\Integration\Fixtures\Event\EventMessageFixture;
use Tests\Integration\Fixtures\Event\EventMessageFixtureHandlerOne;
use Tests\Integration\Fixtures\Event\EventMessageFixtureHandlerTwo;

class TacticianEventBusTest extends ModuleTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function it_save_dispatch_message_in_outbox(): void
    {
        $this->eventProvider->addHandler(
            'test.event.EventMessageFixture',
            EventMessageFixture::class,
            null
        );

        $oneMock = $this->getMockBuilder(EventMessageFixtureHandlerOne::class)->getMock();
        $oneMock->expects(self::once())->method('__invoke');
        $this->container->add(
            EventMessageFixtureHandlerOne::class,
            static fn () => $oneMock
        );

        $twoMock = $this->getMockBuilder(EventMessageFixtureHandlerTwo::class)->getMock();
        $twoMock->expects(self::once())->method('__invoke');
        $this->container->add(
            EventMessageFixtureHandlerTwo::class,
            static fn () => $twoMock
        );


        $this->eventProvider->addHandlerByName(
            'test.event.EventMessageFixture',
            [
                EventMessageFixtureHandlerOne::class,
                EventMessageFixtureHandlerTwo::class,
            ]
        );

        $event = new EventMessageFixture('test event');
        $this->eventBus->dispatch($event);
    }
}
