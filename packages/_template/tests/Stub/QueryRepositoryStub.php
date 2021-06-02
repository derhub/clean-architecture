<?php

namespace Tests\Template\Stub;

use Derhub\Shared\Query\QueryFilter;
use Derhub\Template\AggregateExample\Infrastructure\Database\TemplateQueryRepository;

class QueryRepositoryStub implements TemplateQueryRepository
{
    private mixed $results;

    public function setResults(mixed $data): self
    {
        $this->results = $data;

        return $this;
    }

    public function __construct()
    {
        $this->results = null;
    }

    public function addFilters(array $filters): self
    {
        return $this;
    }

    public function addFilter(QueryFilter $filters): self
    {
        return $this;
    }

    public function applyFilters(): self
    {
        return $this;
    }

    public function results(): array
    {
        return $this->results;
    }

    public function iterableResult(): iterable
    {
        foreach ($this->results as $result) {
            yield $result;
        }
    }

    public function singleResult(): ?array
    {
        return $this->results;
    }

    public function findBy(string $field, mixed $value): array
    {
        return $this->results;
    }

    public function findOne(string $field, mixed $value): ?array
    {
        return $this->results;
    }

    public function exists(string $field, mixed $value): ?bool
    {
        return $this->results;
    }

    public function addFilterSlug(array|string $slug): self
    {
        return $this;
    }

    public function addFilterId(array|string $id): self
    {
        return $this;
    }

    public function addFilterStatus(array|int $status): self
    {
        return $this;
    }
}
