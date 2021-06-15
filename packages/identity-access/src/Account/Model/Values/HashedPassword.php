<?php

namespace Derhub\IdentityAccess\Account\Model\Values;

class HashedPassword
{
    private Password $value;

    public function __construct()
    {
        $this->value = new Password();
    }
}