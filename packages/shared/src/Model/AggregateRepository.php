<?php

namespace Derhub\Shared\Model;

/**
 * @template T
 */
interface AggregateRepository
{
    /**
     * @throw \EB\Shared\Model\Exceptions\AggregateNotFoundException
     * @return T
     */
    public function get(AggregateRootId $id): mixed;
    public function getNextId(): mixed;

    /**
     * @throw \EB\Shared\Model\Exceptions\FailedToSaveAggregateException
     */
    public function save(AggregateRoot $aggregateRoot): void;
}
