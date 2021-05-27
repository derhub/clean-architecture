<?php

namespace Derhub\Shared\Query\Filters;

use Derhub\Shared\Query\QueryFilter;
use Derhub\Shared\Utils\Assert;

class OperationFilter implements QueryFilter
{
    public const OPERATIONS = [
        'equal' => '=',
        'not_equal' => '!=',
        'greater_than' => '>',
        'greater_than_equal' => '>=',
        'less_than' => '<',
        'less_than_equal' => '<=',
    ];

    public function __construct(
        private string $field,
        private string $operation,
        private mixed $value
    ) {
        Assert::inArray($this->operation, array_keys(self::OPERATIONS));
    }

    public function field(): string
    {
        return $this->field;
    }

    public function operation(): string
    {
        return $this->operation;
    }

    public function operationSymbol(): string
    {
        return self::OPERATIONS[$this->operation];
    }

    public function value(): mixed
    {
        return $this->value;
    }

}