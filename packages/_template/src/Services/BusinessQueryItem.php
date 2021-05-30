<?php

namespace Derhub\Template\Services;

use Derhub\Shared\Query\QueryItem;

class BusinessQueryItem implements QueryItem
{
    public function __construct(
        private string $aggregateRootId,
        private ?string $name,
        private ?string $createdAt,
        private ?string $updatedAt,
        private ?string $deletedAt,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->aggregateRootId(),
            'name' => $this->name(),
            'created_at' => $this->createdAt(),
            'updated_at' => $this->updatedAt(),
            'deleted_at' => $this->deletedAt(),
        ];
    }

    public function aggregateRootId(): string
    {
        return $this->aggregateRootId;
    }

    public function name(): ?string
    {
        return $this->name;
    }

    public function createdAt(): ?string
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function deletedAt(): ?string
    {
        return $this->deletedAt;
    }

}