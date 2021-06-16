<?php

namespace Derhub\IdentityAccess\Account\Services\Query;

use Derhub\Shared\Message\Query\Query;

class GetByUsername implements Query
{
    private int $version = 1;

    public function __construct(
        private string $username,
    ) {
    }

    public function username(): string
    {
        return $this->username;
    }

    public function version(): int
    {
        return $this->version;
    }
}