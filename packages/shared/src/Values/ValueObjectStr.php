<?php

namespace Derhub\Shared\Values;

use Stringable;

interface ValueObjectStr extends ValueObject, Stringable
{
    public static function fromString(string $value): self;

    public function toString(): ?string;
}
