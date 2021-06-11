<?php

namespace Derhub\IdentityAccess\Account\Infrastructure;

interface Authorization
{
    public function whyFailed(): string;

    public function success(): bool;
}