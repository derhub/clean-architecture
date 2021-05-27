<?php

namespace Derhub\Shared\Model;

use Derhub\Shared\Values\ValueObjectStr;

interface AggregateRootId extends ValueObjectStr
{
    public static function fromString(string $value): self;
}
