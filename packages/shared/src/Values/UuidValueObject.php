<?php

namespace Derhub\Shared\Values;

use Derhub\Shared\Utils\Assert;
use Derhub\Shared\Utils\Uuid;

trait UuidValueObject
{
    private ?string $value;

    public function __construct()
    {
        $this->value = null;
    }

    private static function init(string|\Stringable $value): static
    {
        $self = new static();
        $self->value = (string)$value;
        return $self;
    }

    public function sameAs(ValueObject $other): bool
    {
        return $other instanceof static
            && $other->toString() === $this->toString();
    }

    public static function fromString(string $value): self
    {
        Assert::uuid($value);
        return self::init($value);
    }

    public static function generate(): static
    {
        return self::init(Uuid::generate());
    }

    public static function validate(array|string $values): bool
    {
        Assert::allUuid((array)$values);
        return true;
    }

    public function toString(): ?string
    {
        return $this->value;
    }

    public function isEmpty(): bool
    {
        return empty($this->value);
    }
}
