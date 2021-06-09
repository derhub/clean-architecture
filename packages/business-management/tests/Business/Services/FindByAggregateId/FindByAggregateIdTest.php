<?php

namespace Tests\BusinessManagement\Business\Services\FindByAggregateId;

use Derhub\BusinessManagement\Business\Model\Business;
use Derhub\BusinessManagement\Business\Services\GetBusinessById\GetBusinessById;
use Derhub\BusinessManagement\Business\Services\GetBusinessById\GetBusinessByIdHandler;
use Derhub\BusinessManagement\Business\Services\GetBusinessById\GetByAggregateIdResponse;
use Derhub\Shared\Message\Query\QueryResponse;
use Derhub\Shared\Utils\Uuid;
use Tests\BusinessManagement\Business\Services\BaseServiceTestCase;

class FindByAggregateIdTest extends BaseServiceTestCase
{
    /**
     * @test
     */
    public function it_fails_when_invalid_id_format(): void
    {
        $this->expectException(\Derhub\Shared\Exceptions\DomainException::class);
        $this->givenExisting(Business::class)
            ->when(new GetBusinessById('invalid id'))
            ->then(\Derhub\BusinessManagement\Business\Services\QueryResponse::class)
        ;
    }
    /**
     * @test
     */
    public function it_return_business_list(): void
    {
        $this->givenExisting(Business::class)
            ->when(new GetBusinessById(Uuid::generate()->toString()))
            ->then(QueryResponse::class)
        ;
    }
    protected function getHandler(): object
    {
        return new GetBusinessByIdHandler($this->queryRepo);
    }
}
