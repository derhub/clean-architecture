<?php

namespace Derhub\Shared\Query\Filters;

use Derhub\Shared\Query\QueryFilter;
use Derhub\Shared\Utils\Assert;

class OperationFilter implements QueryFilter
{
    public const EQ = 'equal';
    public const NEQ = 'not_equal';
    public const GT = 'greater_than';
    public const GTE = 'greater_than_equal';
    public const LT = 'less_than';
    public const LTE = 'less_than_equal';

    public const OPERATIONS = [
        self::EQ => '=',
        self::NEQ => '!=',
        self::GT => '>',
        self::GTE => '>=',
        self::LT => '<',
        self::LTE => '<=',
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

    public static function eq(string $field, $value): self
    {
        return new static($field, self::EQ, $value);
    }

    public static function neq(string $field, $value): self
    {
        return new static($field, self::NEQ, $value);
    }

    public static function gt(string $field, $value): self
    {
        return new static($field, self::GT, $value);
    }

    public static function gte(string $field, $value): self
    {
        return new static($field, self::GTE, $value);
    }

    public static function lt(string $field, $value): self
    {
        return new static($field, self::LT, $value);
    }

    public static function lte(string $field, $value): self
    {
        return new static($field, self::LTE, $value);
    }
}
