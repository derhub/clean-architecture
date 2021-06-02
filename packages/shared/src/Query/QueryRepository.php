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

    /**
     * @throw FailedQueryException
     */
    public function results(): array;

    /**
     * @throw FailedQueryException
     */
    public function iterableResult(): iterable;

    /**
     * @throw NotSingleResultException
     * @throw FailedQueryException
     */
    public function singleResult(): mixed;

    /**
     * @throw FailedQueryException
     */
    public function findBy(string $field, mixed $value): array;

    /**
     * @throw NotSingleResultException
     * @throw FailedQueryException
     */
    public function findOne(string $field, mixed $value): mixed;

    /**
     * @throw FailedQueryException
     */
    public function exists(string $field, mixed $value): ?bool;
}
