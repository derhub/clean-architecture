<?php

namespace Tests\BusinessManagement\Business\Services\Disable;

use Derhub\BusinessManagement\Business\Model\Business;
use Derhub\BusinessManagement\Business\Services\Disable\DisableBusiness;
use Derhub\BusinessManagement\Business\Services\Disable\DisableBusinessHandler;
use Derhub\BusinessManagement\Business\Services\Disable\DisableBusinessResponse;
use Tests\BusinessManagement\Business\Services\BaseServiceTestCase;

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
            ->then(DisableBusinessResponse::class)
        ;
    }
}