<?php

namespace Derhub\Shared\Query;

interface QueryFilterFactory
{
    public function create(
        mixed $id,
        QueryFilter $filter
    ): mixed;
}
