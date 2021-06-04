<?php

namespace Tests\BusinessManagement\Employee;

use Derhub\BusinessManagement\Employee\Module;
use Derhub\Integration\TestUtils\ModuleIntegrationTestCaseCase;
use Derhub\Shared\ModuleInterface;

class ModuleIntegrationTests extends ModuleIntegrationTestCaseCase
{
    protected function getModule(): ModuleInterface
    {
        return new Module();
    }
}