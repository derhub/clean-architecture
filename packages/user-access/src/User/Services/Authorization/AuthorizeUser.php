<?php

namespace Derhub\UserAccess\User\Services\Authorization;

use Derhub\Shared\Message\Command\Command;

class AuthorizeUser implements Command
{
    private int $version = 1;

    public function __construct(
        private string $userId,
        private string $permission,
        private mixed $resourceId = null,
    )
    {
    }

    public function permission(): string
    {
        return $this->permission;
    }

    public function resourceId(): mixed
    {
        return $this->resourceId;
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function version(): int
    {
        return $this->version;
    }
}