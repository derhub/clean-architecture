<?php

namespace Derhub\BusinessManagement\Business\Services\BusinessList;

use Derhub\BusinessManagement\Business\Services\BaseMessage;
use Derhub\Shared\Message\Query\Query;

final class BusinessList extends BaseMessage implements Query
{
    private int $version = 1;

    public function __construct(
        private int $page = 0,
        private int $perPage = 100,
        private array|string|null $businessId = null,
        private array|string|null $slug = null,
        private int|null $enabled = null,
        private int|null $boardingStatus = null,
    ) {
    }

    public function aggregateIds(): array|string|null
    {
        return $this->businessId;
    }

    public function enabled(): int|null
    {
        return $this->enabled;
    }

    public function boardingStatus(): int|null
    {
        return $this->boardingStatus;
    }

    public function page(): int
    {
        return $this->page;
    }

    public function perPage(): int
    {
        return $this->perPage;
    }

    public function slugs(): array|string|null
    {
        return $this->slug;
    }

    public function version(): int
    {
        return $this->version;
    }
}
