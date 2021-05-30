<?php

namespace Derhub\Shared\Query;

use Derhub\Shared\Query\Filters\OperationFilter;
use Derhub\Shared\Query\Filters\PaginationFilter;
use Derhub\Shared\Query\Filters\RangeFilter;
use Derhub\Shared\Query\Filters\SearchFilter;
use Derhub\Shared\Query\Filters\SortFilter;

interface QueryFilterFactory
{
    public function create(
        mixed $id,
        QueryFilter $filter
    ): mixed;
}