<?php

namespace Tests\Integration\Fixtures\Command;

use Tests\Integration\Fixtures\MessageHandlerForTestFixture;

class CommandMessageFixtureHandler extends MessageHandlerForTestFixture
{
    public function __invoke(mixed $msg): CommandMessageFixtureResponse
    {
        return new CommandMessageFixtureResponse();
    }
}