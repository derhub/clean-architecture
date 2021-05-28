<?php

namespace Derhub\Business\Services\Onboard;

use Derhub\Shared\Message\Command\Command;

class OnBoardBusiness implements Command
{
    private int $version = 1;

    public function __construct(
        private string $name,
        private string $ownerId,
        private string $slug,
        private string $country,
        private string $onboardStatus,
    ) {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function ownerId(): string
    {
        return $this->ownerId;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function country(): string
    {
        return $this->country;
    }

    public function onboardStatus(): string
    {
        return $this->onboardStatus;
    }

    public function version(): int
    {
        return $this->version;
    }
}