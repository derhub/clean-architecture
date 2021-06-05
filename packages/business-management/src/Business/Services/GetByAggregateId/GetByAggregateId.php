<?php

namespace Derhub\BusinessManagement\Business\Services\GetByAggregateId;

use Derhub\Shared\Message\Query\Query;

class GetByAggregateId implements Query
{
    private int $version = 1;

    public function __construct(
        private string|array $businessId,
    ) {
    }

    public function aggregateRootId(): ?string
    {
        return $this->businessId;
    }

    public function version(): int
    {
        return $this->version;
    }
}
