<?php

namespace Tests\Business\Services\BusinessList;

use Derhub\Business\Model\Business;
use Derhub\Business\Services\GetBusinesses\GetBusinesses;
use Derhub\Business\Services\GetBusinesses\GetBusinessesHandler;
use Derhub\Business\Services\GetBusinesses\GetBusinessesResponse;
use Tests\Business\Services\BaseServiceTestCase;

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
