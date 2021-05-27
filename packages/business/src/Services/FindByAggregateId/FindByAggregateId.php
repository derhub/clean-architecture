<?php

namespace Derhub\Business\Services\FindByAggregateId;

use Derhub\Business\Services\BaseMessage;
use Derhub\Shared\Message\Query\Query;

class FindByAggregateId extends BaseMessage implements Query
{
    public function __construct(
        private string|array $aggregateRootId,
    ) {
    }

    public function aggregateRootId(): ?string
    {
        return $this->aggregateRootId;
    }
}