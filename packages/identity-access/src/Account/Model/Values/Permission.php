<?php

namespace Derhub\IdentityAccess\Account\Model\Values;

class Permission implements \Derhub\Shared\Values\ValueObjectStr
{
    use BasicStringValue;

    public function __toString()
    {
        if ($this->isEmpty()) {
            return 'empty permission';
        }

        return 'permission '.$this->toString();
    }

}