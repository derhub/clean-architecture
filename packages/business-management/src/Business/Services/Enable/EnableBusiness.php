<?php

namespace Derhub\BusinessManagement\Business\Services\Enable;

use Derhub\BusinessManagement\Business\Services\BaseMessage;

final class EnableBusiness extends BaseMessage implements \Derhub\Shared\Message\Command\Command
{
    private int $version = 1;

    public function __construct(private string $businessId)
    {
    }

    public function aggregateRootId(): string
    {
        return $this->businessId;
    }

    public function version(): int
    {
        return $this->version;
    }
}
