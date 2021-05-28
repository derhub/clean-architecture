<?php

namespace Derhub\Shared\Persistence;

/**
 * @template T
 */
interface DatabasePersistenceRepository
{
    /**
     * @param class-string<T> $className
     */
    public function setAggregateClass(string $className): void;

    /**
     * @psalm-param T $aggregateRoot
     * @param object $aggregateRoot
     */
    public function persist(object $aggregateRoot): void;

    /**
     * @param string|int $aggregateRootId
     * @return T
     */
    public function findById(string|int $aggregateRootId): mixed;
}