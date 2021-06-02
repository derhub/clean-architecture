<?php

namespace Derhub\Template\AggregateExample\Services\GetTemplates;

use Derhub\Shared\Message\Query\Query;
use Derhub\Shared\Query\Filters\SortFilter;
use Derhub\Template\AggregateExample\Shared\SharedValues;

final class GetTemplates implements Query
{
    private int $version = 1;

    public function __construct(
        private int $page,
        private int $perPage,
        private ?array $aggregateIds = null,
        private ?string $name = null,
        private string $sortBy = SharedValues::COL_CREATED_AT,
        private string $sortType = SortFilter::DESC,
    ) {
    }

    public function aggregateIds(): ?array
    {
        return $this->aggregateIds;
    }

    public function name(): ?string
    {
        return $this->name;
    }

    public function page(): int
    {
        return $this->page;
    }

    public function perPage(): int
    {
        return $this->perPage;
    }

    public function sortBy(): string
    {
        return $this->sortBy;
    }

    public function sortType(): string
    {
        return $this->sortType;
    }

    public function version(): int
    {
        return $this->version;
    }
}
