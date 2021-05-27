<?php

namespace Tests\Business;

use Derhub\Business\Module;
use Derhub\Integration\TestUtils\ModuleIntegrationTestCaseCase;
use Derhub\Shared\ModuleInterface;

class BusinessModuleIntegrationTest extends ModuleIntegrationTestCaseCase
{
    protected function getModule(): ModuleInterface
    {
        return new Module();
    }
}
