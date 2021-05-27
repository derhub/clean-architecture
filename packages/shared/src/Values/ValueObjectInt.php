<?php

namespace Derhub\Shared\Values;

use Stringable;

interface ValueObjectInt extends ValueObject, Stringable
{
    public static function fromInt(int $value): self;

    public function toInt(): int;
}