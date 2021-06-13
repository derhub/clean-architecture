<?php

namespace Derhub\Template\AggregateExample\Services;

use Derhub\Shared\Query\QueryItem;

class QueryResultMapper implements \Derhub\Shared\Query\QueryItemMapper
{
    public function fromArray(array $data): QueryItem
    {
        return new QueryResult(
            id: $data['id']->toString(),
        );
    }
}