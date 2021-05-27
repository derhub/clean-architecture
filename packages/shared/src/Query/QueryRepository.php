<?php

namespace Derhub\Shared\Query;

interface QueryRepository
{
    public function addFilters(QueryFilter ...$filters): self;

    public function applyFilters(): mixed;

    public function results(): array;

    public function iterableResult(): iterable;

    public function singleResult(): ?array;

    public function findBy(string $field, mixed $value): array;

    public function findOne(string $field, mixed $value): ?array;

    public function exists(string $field, mixed $value): ?bool;
}