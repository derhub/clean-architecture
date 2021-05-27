<?php

namespace Derhub\Shared\Model;

/**
 * @template TAggregateRootId
 */
interface AggregateRoot
{
    /**
     * @return TAggregateRootId
     */
    public function aggregateRootId(): mixed;

    /**
     * @return DomainEvent[]
     */
    public function pullEvents(): array;
}
