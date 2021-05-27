<?php

namespace Tests\Business\Services\FindByAggregateId;

use Derhub\Business\Model\Business;
use Derhub\Business\Services\FindByAggregateId\FindByAggregateId;
use Derhub\Business\Services\FindByAggregateId\FindByAggregateIdHandler;
use Derhub\Business\Services\FindByAggregateId\FindByAggregateIdResponse;
use Derhub\Shared\Message\Query\QueryResponse;
use Derhub\Shared\Utils\Uuid;
use Tests\Business\Services\BaseServiceTestCase;

class FindByAggregateIdTest extends BaseServiceTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->container->add(
            FindByAggregateIdHandler::class,
            function () {
                return new FindByAggregateIdHandler(
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
            ->when(new FindByAggregateId(Uuid::generate()->toString()))
            ->then(QueryResponse::class)
        ;
    }

    /**
     * @test
     */
    public function it_fails_when_invalid_id_format(): void
    {
        $this->givenExisting(Business::class)
            ->when(new FindByAggregateId('1 2'))
            ->expectExceptionErrors(\Derhub\Shared\Exceptions\AssertionFailedException::class)
            ->then(FindByAggregateIdResponse::class)
        ;
    }
}
