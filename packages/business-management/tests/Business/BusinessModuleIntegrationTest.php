<?php

namespace Tests\BusinessManagement\Business;

use Derhub\BusinessManagement\Business\Module;
use Derhub\Integration\TestUtils\ModuleIntegrationTestCaseCase;
use Derhub\Shared\ModuleInterface;

class BusinessModuleIntegrationTest extends ModuleIntegrationTestCaseCase
{
    protected function getModule(): ModuleInterface
    {
        return new Module();
    }
}
