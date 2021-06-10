<?php

namespace Derhub\UserAccess\User\Model;

use Derhub\UserAccess\User\Model\Values\UserId;

interface Authentication
{
    public function userId(): ?UserId;

    public function whyFailed(): string;

    public function success(): bool;
}