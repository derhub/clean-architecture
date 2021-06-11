<?php

namespace Tests\UserAccess;

use Derhub\Integration\TestUtils\ModuleIntegrationTestCaseCase;

class ModuleIntegrationTest extends ModuleIntegrationTestCaseCase
{
    protected function getModule(): \Derhub\Shared\Module\ModuleInterface
    {
        return new \Derhub\UserAccess\Account\Module();
    }
}
