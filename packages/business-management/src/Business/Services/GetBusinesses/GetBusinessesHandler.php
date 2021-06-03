<?php

namespace Derhub\BusinessManagement\Business\Services\GetBusinesses;

use Derhub\BusinessManagement\Business\Infrastructure\Database\QueryBusinessRepository;
use Derhub\BusinessManagement\Business\Model\Values\BusinessId;
use Derhub\BusinessManagement\Business\Model\Values\Slug;
use Derhub\BusinessManagement\Business\Model\Values\Status;
use Derhub\BusinessManagement\Business\Shared\SharedValues;
use Derhub\Shared\Exceptions\LayeredException;
use Derhub\Shared\Query\Filters\InArrayFilter;
use Derhub\Shared\Query\Filters\OperationFilter;
use Derhub\Shared\Query\Filters\PaginationFilter;
use Derhub\Shared\Query\Filters\SortFilter;

class GetBusinessesHandler
{
    public function __construct(private QueryBusinessRepository $repository)
    {
    }

    public function __invoke(GetBusinesses $msg): GetBusinessesResponse
    {
        $response = new GetBusinessesResponse();

        try {
            $filters = [
                new SortFilter(SharedValues::COL_CREATED_AT, 'desc'),
                new PaginationFilter($msg->page(), $msg->perPage()),
            ];

            $filters =
                $this->addFilterForAggregateId($filters, $msg->aggregateIds());
            $filters = $this->addFilterForSlugs($filters, $msg->slugs());
            $filters = $this->addFilterForStatus($filters, $msg->enabled());
            $query = $this->repository
                ->addFilters($filters);

            $response->setResults($query->iterableResult());
        } catch (LayeredException $e) {
            $response->addError($e::class, $e->getMessage(), $e);
        }

        return $response;
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

        $idAsBytes = [];
        foreach ($aggregateIds as $aggregateId) {
            $idAsBytes[] = BusinessId::fromString($aggregateId)->toBytes();
        }

        $prevFilters[] = $this->createInFilter(
            SharedValues::COL_ID,
            $idAsBytes,
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
                SharedValues::COL_STATUS,
                'equal',
                $statusObj->toInt()
            );

        return $prevFilters;
    }

    private function createInFilter($field, $values): InArrayFilter
    {
        return new InArrayFilter(
            $field,
            $values,
            InArrayFilter::OPERATION_IN
        );
    }
}
