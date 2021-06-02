<?php

namespace Derhub\Shared\Database\Memory;

use Derhub\Shared\Query\QueryFilter;
use Derhub\Shared\Query\QueryItemMapper;
use Derhub\Shared\Query\QueryRepository;

class InMemoryQueryRepository implements QueryRepository
{
    private bool $existsResult;
    private array $filters;
    private mixed $findByResult;
    private mixed $findOneResult;
    private QueryItemMapper $mapper;

    private array $results;
    private mixed $singleResult;

    public function __construct()
    {
        $this->filters = [];
        $this->results = [];
        $this->mapper = new DummyMapper();
    }

    public function addFilter(QueryFilter $filters): QueryRepository
    {
        $this->filters[] = $filters;

        return $this;
    }

    public function addFilters(array $filters): QueryRepository
    {
        $this->filters = array_merge($this->filters, $filters);

        return $this;
    }

    public function applyFilters(): self
    {
        return $this;
    }

    public function exists(string $field, mixed $value): ?bool
    {
        return $this->existsResult;
    }

    public function findBy(string $field, mixed $value): array
    {
        return $this->findByResult;
    }

    public function findOne(string $field, mixed $value): mixed
    {
        return $this->findOneResult;
    }

    public function iterableResult(): \Generator
    {
        foreach ($this->results as $result) {
            yield $this->mapper->fromArray($result);
        }
    }

    public function results(): array
    {
        return iterator_to_array($this->iterableResult());
    }

    public function setExistResult(bool $exists): self
    {
        $this->existsResult = $exists;

        return $this;
    }

    public function setFindByResult(mixed $data): self
    {
        $this->findByResult = $data;

        return $this;
    }

    public function setFindOneResult(mixed $data): self
    {
        $this->findOneResult = $data;

        return $this;
    }

    public function setResult(array $data): self
    {
        $this->results = $data;

        return $this;
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
}
