<?php

namespace Derhub\Business\Model\Values;

use Derhub\Shared\Model\AggregateRootId;
use Derhub\Shared\Values\UuidValueObject;

final class BusinessId implements AggregateRootId
{
    use UuidValueObject;

    public function __toString(): string
    {
        if ($value = $this->toString()) {
            return sprintf('business id %s', $value);
        }

        return 'empty business id';
    }
}
