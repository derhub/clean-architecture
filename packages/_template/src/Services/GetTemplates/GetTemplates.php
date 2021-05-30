<?php

namespace Derhub\Template\Services\GetTemplates;

use Derhub\Shared\Message\Query\Query;

final class GetTemplates implements Query
{
    private int $version = 1;

    public function version(): int
    {
        return $this->version;
    }

    public function __construct(
        private int $page,
        private int $perPage,
        private ?array $aggregateIds = null,
        private ?string $name = null,
    ) {
    }

    public function page(): int
    {
        return $this->page;
    }

    public function perPage(): int
    {
        return $this->perPage;
    }

    public function aggregateIds(): ?array
    {
        return $this->aggregateIds;
    }

    public function name(): ?string
    {
        return $this->name;
    }
}
