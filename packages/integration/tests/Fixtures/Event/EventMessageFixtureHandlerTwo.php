<?php

namespace Tests\Integration\Fixtures\Event;

class EventMessageFixtureHandlerTwo
{
    public function __invoke(EventMessageFixture $msg): void
    {
    }
}
