<?php

namespace Derhub\Business\Model\Values;

use Derhub\Shared\Model\ValueObject\ValueObjectStr;
use Derhub\Shared\ValueObject\UuidValueObject;

final class BusinessId implements ValueObjectStr
{
    use UuidValueObject {
        UuidValueObject::__construct as private;
    }

    public function __toString(): string
    {
        if ($value = $this->toString()) {
            return sprintf('business id %s', $value);
        }

        return 'empty business id';
    }
}
