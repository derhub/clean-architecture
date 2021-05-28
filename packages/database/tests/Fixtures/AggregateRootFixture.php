<?php

namespace Tests\Database\Fixtures;

use Derhub\Shared\Model\AggregateRoot;
use Derhub\Shared\Model\AggregateRootId;
use Derhub\Shared\Model\DomainEvent;
use Derhub\Shared\Model\UseAggregateRoot;
use Derhub\Shared\Model\UseTimestampsWithSoftDelete;

class AggregateRootFixture implements AggregateRoot
{
    use UseAggregateRoot;
    use UseTimestampsWithSoftDelete;

    private AggregateRootIdFixture $aggregateRootId;

    public function __construct(?AggregateRootId $id)
    {
        $this->aggregateRootId = $id ?? new AggregateRootIdFixture();
    }

    public function aggregateRootId(): AggregateRootIdFixture
    {
        return $this->aggregateRootId;
    }
}