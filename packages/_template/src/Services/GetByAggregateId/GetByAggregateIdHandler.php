<?php

namespace Derhub\Template\Services\GetByAggregateId;

use Derhub\Template\Infrastructure\Database\TemplateQueryRepository;
use Derhub\Template\Model\Values\TemplateId;
use Derhub\Template\Services\BusinessQueryItemMapper;
use Derhub\Template\Shared\SharedValues;
use Derhub\Shared\Exceptions\LayeredException;
use Derhub\Shared\Query\Filters\InArrayFilter;
use Derhub\Shared\Query\Filters\OperationFilter;

class GetByAggregateIdHandler
{
    public function __construct(private TemplateQueryRepository $repository) {
    }

    public function __invoke(GetByAggregateId $msg): GetByAggregateIdResponse
    {
        $response = new GetByAggregateIdResponse();
        try {
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