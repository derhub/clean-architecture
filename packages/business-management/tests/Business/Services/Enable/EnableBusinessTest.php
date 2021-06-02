<?php

namespace Tests\BusinessManagement\Business\Services\Enable;

use Derhub\BusinessManagement\Business\Model\Business;
use Derhub\BusinessManagement\Business\Services\Enable\EnableBusiness;
use Derhub\BusinessManagement\Business\Services\Enable\EnableBusinessHandler;
use Derhub\BusinessManagement\Business\Services\Enable\EnableBusinessResponse;
use Tests\BusinessManagement\Business\Services\BaseServiceTestCase;

class EnableBusinessTest extends BaseServiceTestCase
{
    /**
     * @test
     */
    public function it_enable_business(): void
    {
        $this->givenExisting(Business::class)
            ->when(new EnableBusiness($this->lastId->toString()))
            ->then(EnableBusinessResponse::class)
        ;
    }
    protected function getHandler(): object
    {
        return new EnableBusinessHandler($this->repository);
    }
}
