<?php

namespace Derhub\BusinessManagement\Business\Model\Values;

use Derhub\BusinessManagement\Business\Model\Exception\InvalidOwnerIdException;
use Derhub\Shared\Exceptions\DomainException;
use Derhub\Shared\Values\UuidValueObject;
use Derhub\Shared\Values\ValueObjectStr;

class OwnerId implements ValueObjectStr
{
    use UuidValueObject {
        UuidValueObject::fromString as private __fromString;
    }

    public static function fromString(string $value): self
    {
        try {
            return self::__fromString($value);
        } catch (DomainException $e) {
            throw  InvalidOwnerIdException::fromException($e);
        }
    }

    public function __toString()
    {
        if ($value = $this->toString()) {
            return sprintf('business-management owner id %s', $value);
        }

        return 'empty business-management owner id';
    }
}
