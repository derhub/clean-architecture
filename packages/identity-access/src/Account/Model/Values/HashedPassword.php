<?php

namespace Derhub\IdentityAccess\Account\Model\Values;

use Derhub\Shared\Utils\Assert;
use Derhub\Shared\Values\ValueObjectStr;

class HashedPassword implements ValueObjectStr
{
    use BasicStringValue;

    public function __toString()
    {
        if ($this->isEmpty()) {
            return 'empty user password';
        }

        return 'user password [secrete]';
    }
}