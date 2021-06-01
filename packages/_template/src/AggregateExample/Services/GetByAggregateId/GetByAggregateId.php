<?php

namespace Derhub\Template\AggregateExample\Services\GetByAggregateId;

use Derhub\Shared\Message\Query\Query;

class GetByAggregateId implements Query
{
    private int $version = 1;

    public function version(): int
    {
        return $this->version;
    }

    public function __construct(
        private string|array $aggregateRootId,
    ) {
    }

    public function aggregateRootId(): ?string
    {
        return $this->aggregateRootId;
    }
}