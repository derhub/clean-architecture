<?php

namespace Derhub\Business\Services\Enable;

use Derhub\Business\Services\BaseMessage;

final class EnableBusiness extends BaseMessage implements \Derhub\Shared\Message\Command\Command
{
    public function __construct(private string $aggregateRootId)
    {
    }

    public function aggregateRootId(): string
    {
        return $this->aggregateRootId;
    }
}
