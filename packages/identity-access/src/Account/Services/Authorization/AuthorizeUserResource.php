<?php

namespace Derhub\IdentityAccess\Account\Services\Authorization;

use Derhub\Shared\Message\Command\Command;

class AuthorizeUserResource implements Command
{
    private int $version = 1;

    public function __construct(
        private string $userId,
        private ?string $resourceId = null,
        private ?string $resourceUserId = null,
        private ?string $resourceType = null,
        private mixed $resourceValue = null,
    ) {
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function resourceId(): string
    {
        return $this->resourceId;
    }

    public function resourceUserId(): string
    {
        return $this->resourceUserId;
    }

    public function resourceType(): ?string
    {
        return $this->resourceType;
    }

    public function resourceValue(): mixed
    {
        return $this->resourceValue;
    }

    public function version(): int
    {
        return $this->version;
    }
}