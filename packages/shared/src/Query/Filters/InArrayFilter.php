<?php

namespace Derhub\Shared\Query\Filters;

use Derhub\Shared\Query\QueryFilter;
use Derhub\Shared\Utils\Assert;

class InArrayFilter implements QueryFilter
{
    public const OPERATION_IN = 'IN';
    public const OPERATION_NOT_IN = 'NOT IN';

    public static function in(string $field, array $value): self
    {
        return new self($field, $value, self::OPERATION_IN);
    }

    public static function notIn(string $field, array $value): self
    {
        return new self($field, $value, self::OPERATION_NOT_IN);
    }

    public function __construct(
        private string $field,
        private array $value,
        private $operation = self::OPERATION_IN,
    ) {
        Assert::inArray(
            $this->operation,
            [
                self::OPERATION_IN,
                self::OPERATION_NOT_IN,
            ]
        );
    }

    public function field(): string
    {
        return $this->field;
    }

    public function operation(): string
    {
        return $this->operation;
    }

    public function value(): array
    {
        return $this->value;
    }
}
