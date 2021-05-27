<?php

namespace Tests\Business\Services\BusinessList;

use Derhub\Business\Model\Business;
use Derhub\Business\Services\BusinessList\BusinessList;
use Derhub\Business\Services\BusinessList\BusinessListHandler;
use Derhub\Business\Services\BusinessList\BusinessListResponse;
use Tests\Business\Services\BaseServiceTestCase;

class BusinessListTest extends BaseServiceTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->container->add(
            BusinessListHandler::class,
            function () {
                return new BusinessListHandler(
                    $this->queryRepo,
                    $this->queryMapper,
                );
            }
        );
    }

    /**
     * @test
     */
    public function it_return_business_list(): void
    {
        $this->givenExisting(Business::class)
            ->when(new BusinessList(1, 100))
            ->then(BusinessListResponse::class)
        ;
    }
}
