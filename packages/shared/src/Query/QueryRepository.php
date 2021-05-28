<?php

namespace Derhub\Shared\Query;

interface QueryRepository
{
    /**
     * @param QueryFilter[] $filters
     */
    public function addFilters(array $filters): self;

    public function addFilter(QueryFilter $filters): self;

    public function applyFilters(): mixed;

    public function results(): array;

    public function iterableResult(): iterable;

    public function singleResult(): mixed;

    public function findBy(string $field, mixed $value): array;

    public function findOne(string $field, mixed $value): mixed;

    public function exists(string $field, mixed $value): ?bool;
}