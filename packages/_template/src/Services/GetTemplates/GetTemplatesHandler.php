<?php

namespace Derhub\Template\Services\GetTemplates;

use Derhub\Shared\Query\Filters\OperationFilter;
use Derhub\Template\Infrastructure\Database\TemplateQueryRepository;
use Derhub\Template\Model\Values\TemplateId;
use Derhub\Template\Shared\SharedValues;
use Derhub\Shared\Exceptions\LayeredException;
use Derhub\Shared\Query\Filters\InArrayFilter;
use Derhub\Shared\Query\Filters\PaginationFilter;
use Derhub\Shared\Query\Filters\SortFilter;

class GetTemplatesHandler
{
    public function __construct(private TemplateQueryRepository $repository)
    {
    }

    public function __invoke(GetTemplates $msg): GetTemplatesResponse
    {
        $response = new GetTemplatesResponse();
        try {
            $filters = [
                new SortFilter(SharedValues::COL_CREATED_AT, 'desc'),
                new PaginationFilter($msg->page(), $msg->perPage()),
            ];

            $filters =
                $this->addFilterForAggregateId($filters, $msg->aggregateIds());
            $filters =
                $this->addFilterForName($filters, $msg->name());

            $query = $this->repository
                ->addFilters($filters)
                ->iterableResult()
            ;

            $response->setResults($query);
        } catch (LayeredException $e) {
            $response->addError($e::class, $e->getMessage(), $e);
        }

        return $response;
    }

    private function createInFilter($field, $values): InArrayFilter
    {
        return new InArrayFilter(
            $field,
            $values,
            InArrayFilter::OPERATION_IN
        );
    }

    private function addFilterForAggregateId(
        array $prevFilters,
        string|array|null $aggregateIds,
    ): array {
        if (empty($aggregateIds)) {
            return $prevFilters;
        }

        if (! is_array($aggregateIds)) {
            $aggregateIds = [$aggregateIds];
        }

        TemplateId::validate($aggregateIds);

        $prevFilters[] = $this->createInFilter(
            SharedValues::COL_ID,
            $aggregateIds,
        );

        return $prevFilters;
    }

    private function addFilterForName(
        array $prevFilters,
        ?string $searchName
    ): array {
        if (empty($searchName)) {
            return $prevFilters;
        }

        $prevFilters[] =
            new OperationFilter(SharedValues::COL_NAME, 'equal', $searchName);

        return $prevFilters;
    }
}
