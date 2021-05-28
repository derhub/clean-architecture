<?php

namespace Tests\Template\Services\SampleCommand;

use EB\Shared\Message\Command\CommandResponse;
use EB\Template\Model\Template;
use EB\Template\Services\SampleCommand\SampleCommand;
use EB\Template\Services\SampleCommand\SampleCommandHandler;
use Tests\Template\Services\ModuleServiceTest;

class SampleCommandTest extends ModuleServiceTest
{
    public function setUp(): void
    {
        parent::setUp();
        $this->container->add(
            SampleCommandHandler::class,
            function () {
                return new SampleCommandHandler($this->repository);
            }
        );
    }

    /**
     * @test
     */
    public function it_run_sample_command(): void
    {
        $this->givenExisting(Template::class)
            ->when(new SampleCommand($this->lastId->toString()))
            ->then(CommandResponse::class);
    }
}
