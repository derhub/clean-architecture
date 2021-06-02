<?php

namespace Tests\BusinessManagement\Business\Services\BusinessList;

use Derhub\BusinessManagement\Business\Model\Business;
use Derhub\BusinessManagement\Business\Services\GetBusinesses\GetBusinesses;
use Derhub\BusinessManagement\Business\Services\GetBusinesses\GetBusinessesHandler;
use Derhub\BusinessManagement\Business\Services\GetBusinesses\GetBusinessesResponse;
use Tests\BusinessManagement\Business\Services\BaseServiceTestCase;

class BusinessListTest extends BaseServiceTestCase
{
    protected function getHandler(): object
    {
        return new GetBusinessesHandler($this->queryRepo);
    }

    /**
     * @test
     */
    public function it_return_business_list(): void
    {
        $this->givenExisting(Business::class)
            ->when(new GetBusinesses(1, 100))
            ->then(GetBusinessesResponse::class)
        ;
    }
}
