<?php

namespace Tests\BusinessManagement\Business\Services\FindByAggregateId;

use Derhub\BusinessManagement\Business\Model\Business;
use Derhub\BusinessManagement\Business\Services\GetByAggregateId\GetByAggregateId;
use Derhub\BusinessManagement\Business\Services\GetByAggregateId\GetByAggregateIdHandler;
use Derhub\BusinessManagement\Business\Services\GetByAggregateId\GetByAggregateIdResponse;
use Derhub\Shared\Message\Query\QueryResponse;
use Derhub\Shared\Utils\Uuid;
use Tests\BusinessManagement\Business\Services\BaseServiceTestCase;

class FindByAggregateIdTest extends BaseServiceTestCase
{
    protected function getHandler(): object
    {
        return new GetByAggregateIdHandler($this->queryRepo);
    }

    /**
     * @test
     */
    public function it_return_business_list(): void
    {
        $this->givenExisting(Business::class)
            ->when(new GetByAggregateId(Uuid::generate()->toString()))
            ->then(QueryResponse::class)
        ;
    }

    /**
     * @test
     */
    public function it_fails_when_invalid_id_format(): void
    {
        $this->givenExisting(Business::class)
            ->when(new GetByAggregateId('invalid id'))
            ->expectExceptionErrors(
                \Derhub\Shared\Exceptions\AssertionFailedException::class
            )
            ->then(GetByAggregateIdResponse::class)
        ;
    }
}
