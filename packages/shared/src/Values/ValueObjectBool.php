<?php

namespace Derhub\Shared\Values;

use Stringable;

interface ValueObjectBool extends ValueObject, Stringable
{
    public static function fromBoolean(bool $value): self;

    public function toBoolean(): bool;
}
