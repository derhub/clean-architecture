<?php

namespace Derhub\Template\AggregateExample\Services;

use Derhub\Shared\Query\QueryItemMapper;

interface TemplateQueryItemMapper extends QueryItemMapper
{
    public function fromArray(array $data): TemplateQueryItem;
}