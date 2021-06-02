<?php

namespace Derhub\Shared\Infrastructure\FakeSpecification;

use Derhub\Shared\Specification\SpecificationInterface;

abstract class FakeSpecification implements SpecificationInterface
{
    public static function no(): static
    {
        return new static(false);
    }

    public static function yes(): static
    {
        return new static(true);
    }
    public function __construct(private bool $result)
    {
    }

    public function isSatisfiedBy(mixed $_): bool
    {
        return $this->result;
    }
}
