<?php

namespace Derhub\Shared\Database\Memory;

use Derhub\Shared\Query\QueryItemMapper;

class DummyMapper implements QueryItemMapper
{
    public function fromArray(array $data): mixed
    {
        return $data;
    }
}
