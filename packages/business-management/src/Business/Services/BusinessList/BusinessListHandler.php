<?php

namespace Derhub\BusinessManagement\Business\Services\BusinessList;

use Derhub\BusinessManagement\Business\Infrastructure\Database\QueryBusinessRepository;
use Derhub\BusinessManagement\Business\Model\Values\BusinessId;
use Derhub\BusinessManagement\Business\Model\Values\OnBoardStatus;
use Derhub\BusinessManagement\Business\Model\Values\Slug;
use Derhub\BusinessManagement\Business\Model\Values\Status;
use Derhub\BusinessManagement\Business\Services\QueryResponse;
use Derhub\BusinessManagement\Business\Shared\SharedValues;
use Derhub\Shared\Query\Filters\InArrayFilter;
use Derhub\Shared\Query\Filters\OperationFilter;
use Derhub\Shared\Query\Filters\PaginationFilter;
use Derhub\Shared\Query\Filters\SortFilter;

class BusinessListHandler
{
    public function __construct(private QueryBusinessRepository $repository)
    {
    }

    public function __invoke(BusinessList $msg): QueryResponse
    {
        $filters = [
            new SortFilter(SharedValues::COL_CREATED_AT, 'desc'),
            new PaginationFilter($msg->page(), $msg->perPage()),
        ];

        $filters = $this->filterForId($filters, $msg->aggregateIds());
        $filters = $this->filterForSlugs($filters, $msg->slugs());
        $filters = $this->filterForStatus($filters, $msg->enabled());
        $filters = $this->filterForBoarding($filters, $msg->boardingStatus());

        $query = $this->repository->addFilters($filters);

        return new QueryResponse($query->iterableResult());
    }

    private function filterForId(
        array $prevFilters,
        string|array|null $aggregateIds,
    ): array {
        if (empty($aggregateIds)) {
            return $prevFilters;
        }

        $idAsBytes = [];
        foreach ((array)$aggregateIds as $aggregateId) {
            $idAsBytes[] = BusinessId::fromString($aggregateId)->toBytes();
        }

        $prevFilters[] = $this->createInFilter(
            SharedValues::COL_ID,
            $idAsBytes,
        );

        return $prevFilters;
    }

    private function filterForSlugs(
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

    private function filterForStatus(
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

    private function filterForBoarding(
        array $prevFilters,
        string|int|null $boardingStatus
    ): array {
        if ($boardingStatus === null) {
            return $prevFilters;
        }

        $status = OnBoardStatus::fromInt((int)$boardingStatus)->toInt();

        $prevFilters[] =
            OperationFilter::eq(SharedValues::COL_ONBOARD_STATUS, $status);

        return $prevFilters;
    }
}
