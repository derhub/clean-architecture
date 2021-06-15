<?php

namespace Tests\IdentityAccess\AccessProvider;

use Derhub\IdentityAccess\AccessProvider\Module;
use Derhub\Integration\TestUtils\ModuleIntegrationTestCaseCase;
use Derhub\Shared\Module\ModuleInterface;

class AccessProviderIntegrationTest extends ModuleIntegrationTestCaseCase
{

    protected function getModule(): ModuleInterface
    {
        return new Module();
    }
}