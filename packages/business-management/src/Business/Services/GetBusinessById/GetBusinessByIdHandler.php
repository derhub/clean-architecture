<?php

namespace Derhub\BusinessManagement\Business\Services\GetBusinessById;

use Derhub\BusinessManagement\Business\Infrastructure\Database\QueryBusinessRepository;
use Derhub\BusinessManagement\Business\Model\Values\BusinessId;
use Derhub\BusinessManagement\Business\Shared\SharedValues;
use Derhub\Shared\Exceptions\LayeredException;
use Derhub\Shared\Query\Filters\InArrayFilter;
use Derhub\Shared\Query\Filters\OperationFilter;

class GetBusinessByIdHandler
{
    public function __construct(private QueryBusinessRepository $repository)
    {
    }

    public function __invoke(GetBusinessById $msg
    ): \Derhub\BusinessManagement\Business\Services\QueryResponse {
        $aggregateIds = [];
        foreach ((array)$msg->aggregateRootId() as $id) {
            $aggregateIds[] = BusinessId::fromString($id)->toBytes();
        }

        $filter = new InArrayFilter(
            SharedValues::COL_ID,
            $aggregateIds,
            InArrayFilter::OPERATION_IN,
        );

        $find = $this->repository
            ->addFilter($filter)
            ->iterableResult()
        ;

        return new \Derhub\BusinessManagement\Business\Services\QueryResponse(
            $find
        );
    }
}
