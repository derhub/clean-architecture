<?php

namespace Derhub\Shared\Database\Memory;

use Derhub\Shared\Query\QueryFilter;
use Derhub\Shared\Query\QueryItemMapper;
use Derhub\Shared\Query\QueryRepository;

class InMemoryQueryRepository implements QueryRepository
{
    private array $filters;
    private QueryItemMapper $mapper;

    private array $results;
    private mixed $singleResult;
    private mixed $findByResult;
    private bool $existsResult;
    private mixed $findOneResult;

    public function __construct()
    {
        $this->filters = [];
        $this->results = [];
        $this->mapper = new DummyMapper();
    }

    public function addFilters(array $filters): QueryRepository
    {
        $this->filters = array_merge($this->filters, $filters);
        return $this;
    }

    public function addFilter(QueryFilter $filters): QueryRepository
    {
        $this->filters[] = $filters;
        return $this;
    }

    public function applyFilters(): self
    {
        return $this;
    }

    public function setResult(array $data): self
    {
        $this->results = $data;
        return $this;
    }

    public function results(): array
    {
        return iterator_to_array($this->iterableResult());
    }

    public function iterableResult(): \Generator
    {
        foreach ($this->results as $result) {
            yield $this->mapper->fromArray($result);
        }
    }

    public function setSingleResult(mixed $data): self
    {
        $this->singleResult = $data;
        return $this;
    }

    public function singleResult(): mixed
    {
        return $this->singleResult;
    }

    public function setFindByResult(mixed $data): self
    {
        $this->findByResult = $data;
        return $this;
    }

    public function findBy(string $field, mixed $value): array
    {
        return $this->findByResult;
    }

    public function setFindOneResult(mixed $data): self
    {
        $this->findOneResult = $data;
        return $this;
    }

    public function findOne(string $field, mixed $value): mixed
    {
        return $this->findOneResult;
    }

    public function setExistResult(bool $exists): self
    {
        $this->existsResult = $exists;
        return $this;
    }

    public function exists(string $field, mixed $value): ?bool
    {
        return $this->existsResult;
    }
}