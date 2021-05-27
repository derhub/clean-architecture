<?php

namespace Derhub\Business\Model\Values;


use Derhub\Shared\Values\UuidValueObject;
use Derhub\Shared\Values\ValueObjectStr;

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