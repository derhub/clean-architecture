<?php

namespace Derhub\BusinessManagement\Business\Services\GetByAggregateId;

use Derhub\BusinessManagement\Business\Infrastructure\Database\QueryBusinessRepository;
use Derhub\BusinessManagement\Business\Model\Values\BusinessId;
use Derhub\BusinessManagement\Business\Shared\SharedValues;
use Derhub\Shared\Exceptions\LayeredException;
use Derhub\Shared\Query\Filters\InArrayFilter;
use Derhub\Shared\Query\Filters\OperationFilter;

class GetByAggregateIdHandler
{
    public function __construct(private QueryBusinessRepository $repository)
    {
    }

    public function __invoke(GetByAggregateId $msg): GetByAggregateIdResponse
    {
        $response = new GetByAggregateIdResponse();
        try {
            $aggregateIds = $msg->aggregateRootId();
            BusinessId::validate($aggregateIds);

            if (is_array($aggregateIds)) {
                $filter = new InArrayFilter(
                    SharedValues::COL_ID,
                    $aggregateIds,
                    InArrayFilter::OPERATION_IN,
                );
            } else {
                $filter = new OperationFilter(
                    SharedValues::COL_ID,
                    'equal',
                    $aggregateIds,
                );
            }

            $find = $this->repository
                ->addFilter($filter)
                ->iterableResult()
            ;
            $response->setResult($find);
        } catch (LayeredException $e) {
            $response->addErrorFromException($e);
        }

        return $response;
    }
}