<?php

namespace Derhub\Shared\Query\Filters;

use Derhub\Shared\Query\QueryFilter;
use Derhub\Shared\Utils\Assert;

class SortFilter implements QueryFilter
{
    public const ASC = 'asc';
    public const DESC = 'desc';

    public function __construct(
        private string $field,
        private string $value
    ) {
        Assert::inArray($this->value, [self::ASC, self::DESC]);
    }

    public function field(): string
    {
        return $this->field;
    }

    public function value(): string
    {
        return $this->value;
    }
}