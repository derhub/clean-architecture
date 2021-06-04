<?php

namespace Derhub\BusinessManagement\Employee\Services\GetBusinessEmployees;

use Derhub\BusinessManagement\Employee\Infrastructure\Database\EmployeeQueryRepository;
use Derhub\BusinessManagement\Employee\Model\Values\EmployerId;
use Derhub\BusinessManagement\Employee\Services\EmployeeQueryResponse;
use Derhub\Shared\Query\Filters\OperationFilter;
use Derhub\Shared\Query\Filters\PaginationFilter;
use Derhub\Shared\Query\Filters\SortFilter;

class GetBusinessEmployeesHandler
{
    public function __construct(
        private EmployeeQueryRepository $repo
    ) {
    }

    public function __invoke(GetBusinessEmployees $q): EmployeeQueryResponse
    {
        $businessId = EmployerId::fromString($q->businessId());
        $query = $this->repo
            ->addFilter(
                new PaginationFilter(
                    page: $q->page() ?? 0, perPage: $q->perPage() ?? 100
                )
            )
            ->addFilter(new SortFilter('createdAt', SortFilter::DESC))
            ->addFilter(
                new OperationFilter(
                    'aggregateRootId', 'equal', $businessId->toBytes()
                )
            )
        ;

        return new EmployeeQueryResponse($query->iterableResult());
    }
}