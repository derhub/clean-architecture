<?php

namespace Derhub\Shared\Infrastructure\FakeSpecification;

abstract class FakeSpecification
{
    public function __construct(private bool $result)
    {
    }

    public static function yes(): static
    {
        return new static(true);
    }

    public static function no(): static
    {
        return new static(false);
    }

    public function isSatisfiedBy(mixed $_): bool
    {
        return $this->result;
    }
}
