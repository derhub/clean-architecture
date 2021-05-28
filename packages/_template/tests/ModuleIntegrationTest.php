<?php

namespace Tests\Template;

use EB\Integration\TestUtils\ModuleIntegrationTestCaseCase;
use EB\Template\Module;

class ModuleIntegrationTest extends ModuleIntegrationTestCaseCase
{
    protected function getModule(): \EB\Shared\ModuleInterface
    {
        return new Module();
    }
}