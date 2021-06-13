<?php

namespace Derhub\Template\AggregateExample\Model\Values;

use Derhub\Shared\Model\AggregateRootId;
use Derhub\Shared\Values\UuidValueObject;

class SampleId implements AggregateRootId
{
    use UuidValueObject;

    public function __toString(): string
    {
        if ($this->isEmpty()) {
            return 'empty sample id';
        }

        return 'sample id '.$this->toString();
    }
}