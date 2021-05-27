<?php

namespace Derhub\Business\Services\Onboard;

use Derhub\Business\Services\BaseMessage;
use Derhub\Shared\Message\Command\Command;

final class OnBoardBusiness extends BaseMessage implements Command
{
    public function __construct(
        private string $name,
        private string $ownerId,
        private string $slug,
        private string $country,
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
}
