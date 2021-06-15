<?php

namespace Derhub\IdentityAccess\Account\Services\DetailsUpdate;

use Derhub\Shared\Message\Command\Command;

class ChangeUserAccountEmail implements Command
{
    private int $version = 1;

    public function __construct(
        private string $userId,
        private string $email,
    ) {
    }

    public function userId(): string
    {
        return $this->userId;
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