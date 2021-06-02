<?php

namespace Derhub\Template\AggregateExample\Services\GetByAggregateId;

use Derhub\Shared\Query\Filters\InArrayFilter;
use Derhub\Shared\Query\Filters\OperationFilter;
use Derhub\Template\AggregateExample\Infrastructure\Database\TemplateQueryRepository;
use Derhub\Template\AggregateExample\Model\Values\TemplateId;
use Derhub\Template\AggregateExample\Services\QueryResponse;
use Derhub\Template\AggregateExample\Shared\SharedValues;

class GetByAggregateIdHandler
{
    public function __construct(private TemplateQueryRepository $repository)
    {
    }

    public function __invoke(GetByAggregateId $msg): QueryResponse
    {
        $aggregateIds = $msg->aggregateRootId();
        TemplateId::validate($aggregateIds);

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

        $query = $this->repository->addFilter($filter);

        return new QueryResponse($query->iterableResult());
    }
}
