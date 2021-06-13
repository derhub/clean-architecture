<?php

namespace Derhub\IdentityAccess\Account\Services\Query;

use Derhub\Shared\Message\Query\Query;

class GetByUserId implements Query
{
    private int $version = 1;

    public function __construct(
        private string $userId,
    ) {
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