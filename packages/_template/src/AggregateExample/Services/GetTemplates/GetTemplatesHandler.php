<?php

namespace Derhub\Template\AggregateExample\Services\GetTemplates;

use Derhub\Shared\Query\Filters\InArrayFilter;
use Derhub\Shared\Query\Filters\OperationFilter;
use Derhub\Shared\Query\Filters\PaginationFilter;
use Derhub\Shared\Query\Filters\SortFilter;
use Derhub\Template\AggregateExample\Infrastructure\Database\TemplateQueryRepository;
use Derhub\Template\AggregateExample\Model\Values\TemplateId;
use Derhub\Template\AggregateExample\Services\QueryResponse;
use Derhub\Template\AggregateExample\Shared\SharedValues;

class GetTemplatesHandler
{
    public function __construct(private TemplateQueryRepository $repository)
    {
    }

    public function __invoke(GetTemplates $msg): QueryResponse
    {
        $query = $this->repository
            ->addFilter(new SortFilter($msg->sortBy(), $msg->sortType()))
            ->addFilter(new PaginationFilter($msg->page(), $msg->perPage()))
        ;

        if ($idFilter = $this->createIdFilter($msg->aggregateIds())) {
            $query->addFilter($idFilter);
        }

        if ($nameFilter = $this->createNameFilter($msg->name())) {
            $query->addFilter($nameFilter);
        }

        return new QueryResponse($query->iterableResult());
    }

    private function createIdFilter(
        string|array|null $aggregateIds,
    ): ?InArrayFilter {
        if (empty($aggregateIds)) {
            return null;
        }

        if (! is_array($aggregateIds)) {
            $aggregateIds = [$aggregateIds];
        }

        TemplateId::validate($aggregateIds);

        return new InArrayFilter(
            SharedValues::COL_ID,
            $aggregateIds,
            InArrayFilter::OPERATION_IN
        );
    }

    private function createNameFilter(
        ?string $searchName
    ): ?OperationFilter {
        if (empty($searchName)) {
            return null;
        }

        return new OperationFilter(
            SharedValues::COL_NAME,
            'equal',
            $searchName
        );
    }
}
