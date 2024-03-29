<?php

namespace Derhub\BusinessManagement\Business\Services;

use Derhub\Shared\Query\QueryItem;

class BusinessQueryItem implements QueryItem
{
    public function __construct(
        private string $aggregateRootId,
        private ?string $ownerId,
        private ?string $slug,
        private ?string $country,
        private ?string $name,
        private string $status,
        private string $onBoardStatus,
        private ?string $createdAt,
        private ?string $updatedAt,
    ) {
    }

    public function aggregateRootId(): string
    {
        return $this->aggregateRootId;
    }

    public function country(): ?string
    {
        return $this->country;
    }

    public function createdAt(): ?string
    {
        return $this->createdAt;
    }

    public function name(): ?string
    {
        return $this->name;
    }

    public function onBoardStatus(): string
    {
        return $this->onBoardStatus;
    }

    public function ownerId(): ?string
    {
        return $this->ownerId;
    }

    public function slug(): ?string
    {
        return $this->slug;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->aggregateRootId(),
            'owner_id' => $this->ownerId(),
            'slug' => $this->slug(),
            'name' => $this->name(),
            'country' => $this->country(),
            'status' => $this->status(),
            'boarding_status' => $this->onBoardStatus(),
            'created_at' => $this->createdAt(),
            'updated_at' => $this->updatedAt(),
        ];
    }

    public function updatedAt(): ?string
    {
        return $this->updatedAt;
    }
}
