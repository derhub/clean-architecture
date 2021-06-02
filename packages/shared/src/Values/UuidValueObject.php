<?php

namespace Derhub\Shared\Values;

use Derhub\Shared\Utils\Assert;
use Derhub\Shared\Utils\Uuid;

trait UuidValueObject
{
    private ?string $value;

    public static function fromString(string $value): self
    {
        Assert::uuid($value);

        return self::init($value);
    }

    public static function generate(): static
    {
        return self::init(Uuid::generate());
    }

    private static function init(string|\Stringable $value): static
    {
        $self = new static();
        $self->value = (string)$value;

        return $self;
    }

    public static function validate(array|string $values): bool
    {
        Assert::allUuid((array)$values);

        return true;
    }

    public function __construct()
    {
        $this->value = null;
    }

    public function isEmpty(): bool
    {
        return empty($this->value);
    }

    public function sameAs(ValueObject $other): bool
    {
        return $other instanceof static
            && $other->toString() === $this->toString();
    }

    public function toString(): ?string
    {
        return $this->value;
    }
}
