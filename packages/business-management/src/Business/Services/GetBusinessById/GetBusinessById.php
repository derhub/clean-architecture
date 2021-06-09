<?php

namespace Derhub\BusinessManagement\Business\Services\GetBusinessById;

use Derhub\Shared\Message\Query\Query;

class GetBusinessById implements Query
{
    private int $version = 1;

    public function __construct(
        private array|string $businessId,
    ) {
    }

    public function aggregateRootId(): array|string
    {
        return $this->businessId;
    }

    public function version(): int
    {
        return $this->version;
    }
}
