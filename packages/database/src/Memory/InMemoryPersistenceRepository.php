<?php

namespace Derhub\Shared\Database\Memory;

/**
 * @template TAggregateRootId
 */
abstract class InMemoryPersistenceRepository implements InMemoryRepositoryInterface
{
    /**
     * @var ?callable
     *
     */
    private $idCreator;
    private array $saved;

    public function __construct()
    {
        $this->idCreator = null;
        $this->saved = [];
    }

    /**
     * @return TAggregateRootId
     */
    public function createId(): object
    {
        return ($this->idCreator)();
    }

    public function findById(mixed $id): mixed
    {
        return $this->saved[$id->toString()] ?? null;
    }

    public function persist(object $object): void
    {
        $this->saved[$object->aggregateRootId()->toString()] = $object;
    }

    public function setCreatorId(callable $createId): void
    {
        $this->idCreator = $createId;
    }
}
