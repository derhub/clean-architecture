<?php

namespace Tests\Integration\Fixtures\Event;

class EventMessageFixtureHandlerOne
{
    public function __invoke(EventMessageFixture $msg): void
    {
    }
}
