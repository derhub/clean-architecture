<?php

namespace Derhub\Business\Services;

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

    public function toArray(): array
    {
        return [
            'id' => $this->aggregateRootId(),
            'owner_id' => $this->ownerId(),
            'slug' => $this->slug(),
            'name' => $this->name(),
            'country' => $this->country(),
            'status' => $this->status(),
            'onboard_status' => $this->onBoardStatus(),
            'created_at' => $this->createdAt(),
            'updated_at' => $this->updatedAt(),
        ];
    }

    public function aggregateRootId(): string
    {
        return $this->aggregateRootId;
    }

    public function ownerId(): ?string
    {
        return $this->ownerId;
    }

    public function slug(): ?string
    {
        return $this->slug;
    }

    public function name(): ?string
    {
        return $this->name;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function onBoardStatus(): string
    {
        return $this->onBoardStatus;
    }

    public function createdAt(): ?string
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function country(): ?string
    {
        return $this->country;
    }
}