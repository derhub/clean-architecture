<?php

namespace Tests\Database\Fixtures;

use Derhub\Shared\Model\AggregateRootId;
use Derhub\Shared\Values\UuidValueObject;

class AggregateRootIdFixture implements AggregateRootId
{
    use UuidValueObject;

    public function __toString()
    {
        if ($this->isEmpty()) {
            return 'empty aggregate test id';
        }

        return 'aggregate test id'.$this->toString();
    }
}
