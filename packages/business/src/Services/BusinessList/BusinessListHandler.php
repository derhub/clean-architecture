<?php

namespace Derhub\Business\Services\BusinessList;

use Derhub\Business\Infrastructure\Database\QueryBusinessRepository;
use Derhub\Business\Model\Values\BusinessId;
use Derhub\Business\Model\Values\Slug;
use Derhub\Business\Model\Values\Status;
use Derhub\Business\Services\BusinessQueryItemMapper;
use Derhub\Business\Shared\SharedValues;
use Derhub\Shared\Exceptions\LayeredException;
use Derhub\Shared\Query\Filters\InArrayFilter;
use Derhub\Shared\Query\Filters\OperationFilter;
use Derhub\Shared\Query\Filters\PaginationFilter;
use Derhub\Shared\Query\Filters\SortFilter;

class BusinessListHandler
{
    public function __construct(
        private QueryBusinessRepository $repository,
        private BusinessQueryItemMapper $mapper,
    ) {
    }

    public function __invoke(BusinessList $msg): BusinessListResponse
    {
        $response = new BusinessListResponse($this->mapper);
        try {
            $filters = [
                new SortFilter(SharedValues::COL_CREATED_AT, 'desc'),
                new PaginationFilter($msg->page(), $msg->perPage()),
            ];

            $filters =
                $this->addFilterForAggregateId($filters, $msg->aggregateIds());
            $filters = $this->addFilterForSlugs($filters, $msg->slugs());
            $filters = $this->addFilterForStatus($filters, $msg->enabled());

            $results = $this->repository
                ->addFilters(
                    ...$filters
                )
                ->iterableResult()
            ;

            $response->setResults($results);
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

        BusinessId::validate($aggregateIds);

        $prevFilters[] = $this->createInFilter(
            SharedValues::COL_ID,
            $aggregateIds,
        );

        return $prevFilters;
    }

    private function addFilterForSlugs(
        array $prevFilters,
        ?array $slugs
    ): array {
        if (empty($slugs)) {
            return $prevFilters;
        }

        Slug::validate($slugs);
        $prevFilters[] = $this->createInFilter(
            SharedValues::COL_SLUG,
            $slugs,
        );

        return $prevFilters;
    }

    private function addFilterForStatus(
        array $prevFilters,
        string|int|null $status,
    ): array {
        if ($status === null) {
            return $prevFilters;
        }

        if (is_string($status)) {
            $statusObj = Status::fromString($status);
        } else {
            $statusObj = Status::fromInt($status);
        }

        $prevFilters[] =
            new OperationFilter(
                SharedValues::COL_STATUS, 'equal', $statusObj->toInt()
            );
        return $prevFilters;
    }
}
