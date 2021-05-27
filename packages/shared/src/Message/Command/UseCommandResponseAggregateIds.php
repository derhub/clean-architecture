<?php

namespace Derhub\Shared\Message\Command;

use Derhub\Shared\Model\AggregateRootId;

trait UseCommandResponseAggregateIds
{
    /**
     * @var array<string, AggregateRootId>
     */
    protected array $aggregateIds = [];

    public function aggregateRootIds(): array
    {
        return $this->aggregateIds;
    }

    /**
     * @param string $aggregateClass
     * @param \Derhub\Shared\Model\AggregateRootId $aggregateRootId
     * @return self
     */
    public function addAggregateId(
        string $aggregateClass,
        mixed $aggregateRootId
    ): self {
        $this->aggregateIds[$aggregateClass] = $aggregateRootId;
        return $this;
    }
}