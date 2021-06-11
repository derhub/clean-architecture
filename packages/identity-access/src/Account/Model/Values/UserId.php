<?php

namespace Derhub\IdentityAccess\Account\Model\Values;

use Derhub\Shared\Values\UuidValueObject;
use Derhub\Shared\Values\ValueObjectStr;

class UserId implements ValueObjectStr
{
    use UuidValueObject;

    public function __toString()
    {
        if ($this->isEmpty()) {
            return 'empty user id';
        }

        return 'user id '.$this->value;
    }
}