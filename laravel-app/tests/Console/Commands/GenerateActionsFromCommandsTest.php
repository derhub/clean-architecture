<?php

namespace Tests\Console\Commands;

use App\Console\Commands\GenerateActionsConsole;
use Derhub\Integration\ModuleService\ModuleServiceImpl;
use Tests\TestCase;

class GenerateActionsFromCommandsTest extends TestCase
{
    /**
     * @test
     */
    public function it_generate_actions_base_on_register_commands(): void
    {
        $moduleService = $this->app->make(ModuleServiceImpl::class);
        $console = new GenerateActionsConsole($moduleService);
        $console->handle();
    }
}
