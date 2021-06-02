<?php

namespace Derhub\Shared\Query;

interface QueryFilter
{
    public function field(): mixed;
    public function value(): mixed;
}
