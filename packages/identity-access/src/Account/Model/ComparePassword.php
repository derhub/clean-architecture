<?php

namespace Derhub\IdentityAccess\Account\Model;

interface ComparePassword
{
    public function compare(string $plainPassword, string $hashedPassword): bool;
}