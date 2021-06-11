<?php

namespace Derhub\IdentityAccess\Account\Model\Values;

use Derhub\Shared\Values\UuidValueObject;
use Derhub\Shared\Values\ValueObjectStr;

class TenantId implements ValueObjectStr
{
    use UuidValueObject;

    public function __toString()
    {
        if ($this->isEmpty()) {
            return 'empty user tenant id';
        }

        return 'user tenant id '.$this->toString();
    }
}