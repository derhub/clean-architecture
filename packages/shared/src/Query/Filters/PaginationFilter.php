<?php

namespace Derhub\Shared\Query\Filters;

use Derhub\Shared\Query\QueryFilter;

class PaginationFilter implements QueryFilter
{
    public function __construct(
        private int $page,
        private int $perPage,
    ) {
    }

    public function page(): int
    {
        return $this->page;
    }

    public function perPage(): int
    {
        return $this->perPage;
    }

    public function field(): mixed
    {
        return null;
    }

    public function value(): mixed
    {
        return null;
    }
}
