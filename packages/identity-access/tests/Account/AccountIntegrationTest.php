<?php

namespace Tests\IdentityAccess\Account;

use Derhub\IdentityAccess\Account\Module;
use Derhub\Integration\TestUtils\ModuleIntegrationTestCaseCase;

class AccountIntegrationTest extends ModuleIntegrationTestCaseCase
{
    protected function getModule(): \Derhub\Shared\Module\ModuleInterface
    {
        return new Module();
    }
}
