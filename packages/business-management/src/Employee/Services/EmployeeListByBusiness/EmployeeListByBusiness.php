<?php

namespace Derhub\BusinessManagement\Employee\Services\EmployeeListByBusiness;

use Derhub\Shared\Message\Query\Query;

class EmployeeListByBusiness implements Query
{
    private int $version = 1;

    public function __construct(
        private string $businessId,
        private int $page = 0,
        private int $perPage = 100,
    ) {
    }

    public function version(): int
    {
        return $this->version;
    }

    public function businessId(): string
    {
        return $this->businessId;
    }

    public function page(): int
    {
        return $this->page;
    }

    public function perPage(): int
    {
        return $this->perPage;
    }
}