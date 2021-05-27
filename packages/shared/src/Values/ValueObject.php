<?php

namespace Derhub\Shared\Values;

interface ValueObject
{
    public function sameAs(ValueObject $other): bool;
}
