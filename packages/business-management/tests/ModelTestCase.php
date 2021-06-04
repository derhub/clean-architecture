<?php

namespace Tests\BusinessManagement;


use Derhub\Shared\Model\DomainEvent;
use Derhub\Shared\Values\DateTimeLiteral;
use PHPUnit\Framework\TestCase;

class ModelTestCase extends TestCase
{
    /**
     * @param array<class-string> $actual
     * @param \Derhub\Shared\Model\DomainEvent[] $events
     */
    protected function assertEvents(array $actual, array $events): void
    {
        $classStringEvents =
            array_map(static fn (DomainEvent $e) => $e::class, $events);
        self::assertEquals($actual, $classStringEvents);
    }

    protected function setUp(): void
    {
        parent::setUp();
        DateTimeLiteral::freezeAt(DateTimeLiteral::now());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        DateTimeLiteral::unFreeze();
    }
}