<?php

namespace Derhub\BusinessManagement\Business\Model\Values;

use Derhub\Shared\Model\AggregateRootId;
use Derhub\Shared\Values\UuidValueObject;

final class BusinessId implements AggregateRootId
{
    use UuidValueObject;

    public function __toString(): string
    {
        if ($value = $this->toString()) {
            return sprintf('business-management id %s', $value);
        }

        return 'empty business-management id';
    }
}
