<?php

namespace Tests\Business\Fixtures\Services;

use Derhub\Business\Infrastructure\Database\QueryBusinessRepository;
use Derhub\Shared\Query\QueryFilter;

class QueryRepositoryStub implements QueryBusinessRepository
{

    private mixed $results;
    public function __construct()
    {
        $this->results = null;
    }

    public function addFilters(QueryFilter ...$filters): self
    {
        return $this;
    }

    public function applyFilters(): self
    {
        return $this;
    }

    public function setResults(mixed $data): self
    {
        $this->results = $data;
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
}