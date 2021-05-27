<?php

namespace Tests\Business\Services\Disable;

use Derhub\Business\Infrastructure\InMemoryBusinessRepository;
use Derhub\Business\Model\Business;
use Derhub\Business\Model\Values\BusinessId;
use Derhub\Business\Module;
use Derhub\Business\Services\Disable\DisableBusiness;
use Derhub\Business\Services\Disable\DisableBusinessHandler;
use Derhub\Business\Services\Disable\DisableBusinessResponse;
use Derhub\Shared\ModuleInterface;
use Tests\Business\Services\BaseServiceTestCase;

class DisableBusinessTest extends BaseServiceTestCase
{
    /**
     * @test
     */
    public function it_disable_business(): void
    {
        $this->givenExisting(Business::class)
            ->when(new DisableBusiness($this->lastId->toString()))
            ->then(DisableBusinessResponse::class);

    }
}
