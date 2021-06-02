<?php

namespace Derhub\BusinessManagement\Business\Services\Enable;

use Derhub\BusinessManagement\Business\Services\BaseMessage;

final class EnableBusiness extends BaseMessage implements \Derhub\Shared\Message\Command\Command
{
    private int $version = 1;

    public function version(): int
    {
        return $this->version;
    }

    public function __construct(private string $aggregateRootId)
    {
    }

    public function aggregateRootId(): string
    {
        return $this->aggregateRootId;
    }
}
