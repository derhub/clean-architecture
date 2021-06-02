<?php

namespace Tests\Integration\Fixtures\Command;

use Derhub\Shared\Message\Command\AbstractCommandResponse;
use Tests\Integration\Fixtures\TestModule;

class CommandMessageFixtureResponse extends AbstractCommandResponse
{
    public function aggregate(): string
    {
        return TestModule::ID;
    }
}
