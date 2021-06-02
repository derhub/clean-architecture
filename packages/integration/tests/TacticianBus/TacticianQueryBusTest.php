<?php

namespace Tests\Integration\TacticianBus;

use Tests\Integration\Fixtures\Query\QueryMessageFixture;
use Tests\Integration\Fixtures\Query\QueryMessageFixtureHandler;
use Tests\Integration\Fixtures\Query\QueryResponseFixture;
use Tests\Integration\Fixtures\SimpleValueObjFixture;
use Tests\Integration\TestCase;

class TacticianQueryBusTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->container->add(
            QueryMessageFixtureHandler::class,
            static fn () => new QueryMessageFixtureHandler(),
        );
    }

    /**
     * @test
     */
    public function it_can_dispatch_multiple_query_message(): void
    {
        ['bus' => $bus, 'listener' => $locator] = $this->createQueryBus();
        $msg = new QueryMessageFixture(
            SimpleValueObjFixture::fromString('tst'),
            'test'
        );

        $locator->addHandler(
            'QueryMessageFixture',
            QueryMessageFixture::class,
            QueryMessageFixtureHandler::class
        );

        $results = $bus->dispatch($msg, $msg);

        self::assertIsArray($results);
        foreach ($results as $result) {
            self::assertInstanceOf(QueryResponseFixture::class, $result);
            self::assertInstanceOf(
                QueryMessageFixture::class,
                $result->getMessage()
            );
        }
    }

    /**
     * @test
     */
    public function it_dispatch_query_message(): void
    {
        ['bus' => $bus, 'listener' => $locator] = $this->createQueryBus();
        $msg = new QueryMessageFixture(
            SimpleValueObjFixture::fromString('tst'),
            'test'
        );

        $locator->addHandler(
            'QueryMessageFixture',
            QueryMessageFixture::class,
            QueryMessageFixtureHandler::class
        );

        $result = $bus->dispatch($msg);

        self::assertInstanceOf(QueryResponseFixture::class, $result);
        self::assertInstanceOf(
            QueryMessageFixture::class,
            $result->getMessage()
        );
    }
}
