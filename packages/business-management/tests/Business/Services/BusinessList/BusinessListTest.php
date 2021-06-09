<?php

namespace Tests\BusinessManagement\Business\Services\BusinessList;

use Derhub\BusinessManagement\Business\Model\Business;
use Derhub\BusinessManagement\Business\Services\BusinessList\BusinessList;
use Derhub\BusinessManagement\Business\Services\BusinessList\BusinessListHandler;
use Derhub\BusinessManagement\Business\Services\BusinessList\GetBusinessesResponse;
use Tests\BusinessManagement\Business\Services\BaseServiceTestCase;

class BusinessListTest extends BaseServiceTestCase
{
    /**
     * @test
     */
    public function it_return_business_list(): void
    {
        $this->givenExisting(Business::class)
            ->when(new BusinessList(1, 100))
            ->then(\Derhub\BusinessManagement\Business\Services\QueryResponse::class)
        ;
    }
    protected function getHandler(): object
    {
        return new BusinessListHandler($this->queryRepo);
    }
}
