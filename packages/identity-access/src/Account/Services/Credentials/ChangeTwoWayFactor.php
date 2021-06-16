<?php

namespace Derhub\IdentityAccess\Account\Services\Credentials;

use Derhub\Shared\Message\Command\Command;

class ChangeTwoWayFactor implements Command
{
    private int $version = 1;

    public function __construct(
        private string $userId,
        private string $secrete,
        private string $recoveryCodes,
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

    public function secrete(): string
    {
        return $this->secrete;
    }

    public function recoveryCodes(): string
    {
        return $this->recoveryCodes;
    }
}