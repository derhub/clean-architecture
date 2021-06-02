<?php

namespace Derhub\Shared\Values;

use Derhub\Shared\Utils\Assert;

class Email implements ValueObjectStr
{
    private ?string $value;

    public function __construct()
    {
        $this->value = null;
    }

    private static function init(string $value): static
    {
        Assert::email($value);
        $self = new static();
        $self->value = $value;

        return $self;
    }

    public static function fromString(string $value): self
    {
        return static::init($value);
    }

    public function __toString()
    {
        return $this->toString() ?? '';
    }

    public function sameAs(ValueObject $other): bool
    {
        return $other::class === static::class &&
            $other->value() === $this->value();
    }

    public function toString(): ?string
    {
        return $this->value;
    }
}
