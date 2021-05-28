<?php

namespace Derhub\Shared\Message\Command;

use Derhub\Shared\Message\AbstractMessageResponse;

abstract class AbstractCommandResponse extends AbstractMessageResponse implements CommandResponse
{
    private ?string $aggregateRootId;

    public function __construct(?string $aggregateRootId = null)
    {
        parent::__construct();
        $this->aggregateRootId = $aggregateRootId;
    }

    /**
     * @param string $aggregateRootId
     */
    public function setAggregateRootId(string $aggregateRootId): void
    {
        $this->aggregateRootId = $aggregateRootId;
    }

    public function aggregateRootId(): ?string
    {
        return $this->aggregateRootId;
    }
}