<?php

namespace Derhub\UserAccess\User\Model;

interface Authorization
{
    public function whyFailed(): string;

    public function success(): bool;
}