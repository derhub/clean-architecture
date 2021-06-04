<?php

namespace Derhub\BusinessManagement\Employee\Services\GetBusinessEmployees;

use Derhub\BusinessManagement\Employee\Model\Values\EmployerId;
use Derhub\Shared\Message\Query\Query;

class GetBusinessEmployees implements Query
{
    private int $version = 1;

    public function __construct(
        private EmployerId $businessId,
        private int $page = 0,
        private int $perPage = 100,
    ) {
    }

    public function version(): int
    {
        return $this->version;
    }

    public function businessId(): EmployerId
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