<?php

namespace Tests\Template;

use Derhub\Integration\TestUtils\ModuleIntegrationTestCaseCase;
use Derhub\Template\Module;

class ModuleIntegrationTest extends ModuleIntegrationTestCaseCase
{
    protected function getModule(): \Derhub\Shared\ModuleInterface
    {
        return new Module();
    }
}