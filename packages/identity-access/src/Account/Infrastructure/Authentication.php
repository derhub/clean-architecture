<?php

namespace Derhub\IdentityAccess\Account\Infrastructure;

interface Authentication
{
    public function userId(): ?string;

    public function whyFailed(): string;

    public function success(): bool;
}