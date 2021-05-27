<?php

namespace Derhub\Business\Model\Values;

use Derhub\Shared\Model\ValueObject\ValueObjectStr;
use Derhub\Shared\ValueObject\UuidValueObject;

class OwnerId implements ValueObjectStr
{
    use UuidValueObject;

    public function __toString()
    {
        if ($value = $this->toString()) {
            return sprintf('business owner id %s', $value);
        }

        return 'empty business owner id';
    }

}