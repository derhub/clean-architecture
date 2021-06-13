<?php

namespace Derhub\Template\AggregateExample\Services;

class QueryResult implements \Derhub\Shared\Query\QueryItem
{
    public function __construct(
        private string $id,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
        ];
    }
}