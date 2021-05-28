<?php

namespace Tests\Business\Fixtures\Services;

use Derhub\Business\Infrastructure\Database\QueryBusinessRepository;
use Derhub\Shared\Query\QueryFilter;

class QueryRepositoryStub implements QueryBusinessRepository
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

    public function addFilterSlug(array|string $slug): QueryBusinessRepository
    {
        return $this;
    }

    public function addFilterId(array|string $id): QueryBusinessRepository
    {
        return $this;
    }

    public function addFilterStatus(array|int $status): QueryBusinessRepository
    {
        return $this;
    }
}