<?php

namespace Derhub\Shared\Query\Filters;

use Derhub\Shared\Query\QueryFilter;
use Derhub\Shared\Utils\Assert;

class RangeFilter implements QueryFilter
{
    public const EQUAL = '=';
    public const NONE = '';

    public function __construct(
        private string $field,
        private mixed $minValue,
        private mixed $maxValue,
        private string $operation = self::NONE,
    ) {
        Assert::inArray(
            $this->operation,
            [self::NONE, self::EQUAL]
        );
    }

    public function field(): string
    {
        return $this->field;
    }

    public function value(): array
    {
        return [$this->minValue(), $this->maxValue()];
    }

    public function minValue(): mixed
    {
        return $this->minValue;
    }

    public function maxValue(): mixed
    {
        return $this->maxValue;
    }

    public function operation(): string
    {
        return $this->operation;
    }

    public function operationSymbol(): ?string
    {
        return $this->operation;
    }

}