<?php

namespace Derhub\BusinessManagement\Business\Services\GetBusinesses;

use Derhub\BusinessManagement\Business\Services\BaseMessage;
use Derhub\Shared\Message\Query\Query;

final class GetBusinesses extends BaseMessage implements Query
{
    private int $version = 1;

    public function __construct(
        private int $page,
        private int $perPage,
        private ?array $businessId = null,
        private ?array $slug = null,
        private null|bool|int $enabled = null,
        private null|string|int|array $onBoardType = null,
    ) {
    }

    public function aggregateIds(): ?array
    {
        return $this->businessId;
    }

    public function enabled(): ?bool
    {
        return $this->enabled;
    }

    public function onBoardType(): null|string|int|array
    {
        return $this->onBoardType;
    }

    public function page(): int
    {
        return $this->page;
    }

    public function perPage(): int
    {
        return $this->perPage;
    }

    public function slugs(): ?array
    {
        return $this->slug;
    }

    public function version(): int
    {
        return $this->version;
    }
}
