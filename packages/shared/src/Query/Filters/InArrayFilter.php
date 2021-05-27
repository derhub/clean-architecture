<?php

namespace Derhub\Shared\Query\Filters;

use Derhub\Shared\Query\QueryFilter;
use Derhub\Shared\Utils\Assert;

class InArrayFilter implements QueryFilter
{
    public const OPERATION_IN = 'IN';
    public const OPERATION_NOT_IN = 'NOT IN';

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

    public function value(): array
    {
        return $this->value;
    }

    public function operration(): string
    {
        return $this->operation;
    }
}