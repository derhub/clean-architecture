<?php

namespace Derhub\Shared\Query\Filters;

use Derhub\Shared\Query\QueryFilter;

class SearchFilter implements QueryFilter
{
    public function __construct(
        private string $field,
        private mixed $value,
    ) {
    }

    public function field(): string
    {
        return $this->field;
    }

    public function value(): mixed
    {
        return $this->value;
    }
}
