<?php

namespace Derhub\Template\Services;

use Derhub\Shared\Query\QueryItemMapper;

interface BusinessQueryItemMapper extends QueryItemMapper
{
    public function fromArray(array $data): BusinessQueryItem;
}