<?php

namespace Derhub\Business\Services\FindByAggregateId;

use Derhub\Business\Infrastructure\Database\QueryBusinessRepository;
use Derhub\Business\Model\Values\BusinessId;
use Derhub\Business\Services\BusinessQueryItemMapper;
use Derhub\Business\Shared\SharedValues;
use Derhub\Shared\Exceptions\LayeredException;
use Derhub\Shared\Query\Filters\InArrayFilter;
use Derhub\Shared\Query\Filters\OperationFilter;

class FindByAggregateIdHandler
{
    public function __construct(
        private QueryBusinessRepository $repository,
        private BusinessQueryItemMapper $mapper
    ) {
    }

    public function __invoke(FindByAggregateId $msg): FindByAggregateIdResponse
    {
        $response = new FindByAggregateIdResponse($this->mapper);
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
                ->addFilters($filter)
                ->iterableResult()
            ;
            $response->setResult($find);
        } catch (LayeredException $e) {
            $response->addErrorFromException($e);
        }

        return $response;
    }
}