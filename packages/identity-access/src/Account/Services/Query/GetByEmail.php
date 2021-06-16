<?php

namespace Derhub\IdentityAccess\Account\Services\Query;

use Derhub\Shared\Message\Query\Query;

class GetByEmail implements Query
{
    private int $version = 1;

    public function __construct(
        private string $email,
    ) {
    }

    public function email(): string
    {
        return $this->email;
    }

    public function version(): int
    {
        return $this->version;
    }
}