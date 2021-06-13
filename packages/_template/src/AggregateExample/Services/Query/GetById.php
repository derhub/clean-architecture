<?php

namespace Derhub\Template\AggregateExample\Services\Query;

use Derhub\Shared\Message\Query\Query;

class GetById implements Query
{
    private int $version = 1;

    public function __construct(
        private string $id,
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function version(): int
    {
        return $this->version;
    }
}