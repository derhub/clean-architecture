<?php

namespace EB\Template\Services\SampleQuery;

use EB\Shared\Message\Query\Query;

class SampleQuery implements Query
{
    private int $version = 1;

    public function __construct(private array $aggregateRootIds)
    {
    }

    public function aggregateRootIds(): array
    {
        return $this->aggregateRootIds;
    }


    public function version(): int
    {
        return $this->version;
    }
}