<?php

namespace Derhub\Shared\Database\Doctrine;

interface TenantIdentityProvider
{
    public function getTenantId(): string|int;
}