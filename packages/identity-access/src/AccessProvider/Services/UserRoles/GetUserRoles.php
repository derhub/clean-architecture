<?php

namespace Derhub\IdentityAccess\AccessProvider\Services\UserRoles;

use Derhub\Shared\Message\Query\Query;

class GetUserRoles implements Query
{
    private int $version = 1;

    public function __construct(
        private string $user,
    ) {
    }

    public function user(): string
    {
        return $this->user;
    }

    public function version(): int
    {
        return $this->version;
    }
}