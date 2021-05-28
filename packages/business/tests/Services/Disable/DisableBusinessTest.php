<?php

namespace Tests\Business\Services\Disable;

use Derhub\Business\Model\Business;
use Derhub\Business\Services\Disable\DisableBusiness;
use Derhub\Business\Services\Disable\DisableBusinessHandler;
use Derhub\Business\Services\Disable\DisableBusinessResponse;
use Tests\Business\Services\BaseServiceTestCase;

class DisableBusinessTest extends BaseServiceTestCase
{
    protected function getHandler(): object
    {
        return new DisableBusinessHandler($this->repository);
    }

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
