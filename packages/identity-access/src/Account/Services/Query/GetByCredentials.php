<?php

namespace Derhub\IdentityAccess\Account\Services\Query;

use Derhub\Shared\Message\Query\Query;

class GetByCredentials implements Query
{
    private int $version = 1;

    public function __construct(
        private string $emailOrUsername,
    ) {
    }

    public function emailOrUsername(): string
    {
        return $this->emailOrUsername;
    }
    
    public function version(): int
    {
        return $this->version;
    }
}