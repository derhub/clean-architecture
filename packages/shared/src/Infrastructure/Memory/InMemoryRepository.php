<?php

namespace Derhub\Shared\Infrastructure\Memory;

use Derhub\Shared\Model\AggregateRootId;
use Derhub\Shared\Model\DomainEvent;

/**
 * @template TAggregateRootId
 */
abstract class InMemoryRepository implements InMemoryRepositoryInterface
{
     /**
     * @var ?callable
     *
     */
    private $createId;
    private array $saved;

    public function __construct()
    {
        $this->createId = null;
        $this->saved = [];
    }

    public function setCreatorId(callable $createId): void
    {
        $this->createId = $createId;
    }

    /**
     * @return TAggregateRootId
     */
    public function createId(): object
    {
        return ($this->createId)();
    }

    public function persist(object $object): void
    {
        $this->saved[$object->aggregateRootId()->toString()] = $object;
    }

    public function findById(mixed $id): mixed
    {
        return $this->saved[$id->toString()] ?? null;
    }
}
