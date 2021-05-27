<?php

namespace Derhub\Business\Services\BusinessList;

use Derhub\Business\Services\BaseMessage;
use Derhub\Business\Shared\SharedValues;
use Derhub\Shared\Message\Query\Query;

final class BusinessList extends BaseMessage implements Query
{
    public function __construct(
        private int $page,
        private int $perPage,
        private ?array $aggregateIds = null,
        private ?array $slugs = null,
        private null|bool|int $enabled = null,
        private null|string|int|array $onboardType = null,
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

    public function slugs(): ?array
    {
        return $this->slugs;
    }

    public function enabled(): ?bool
    {
        return $this->enabled;
    }

    public function onboardType(): null|string|int|array
    {
        return $this->onboardType;
    }
}
