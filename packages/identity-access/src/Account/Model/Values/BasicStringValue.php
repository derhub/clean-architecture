<?php

namespace Derhub\IdentityAccess\Account\Model\Values;

use Derhub\Shared\Values\ValueObject;

trait BasicStringValue
{
    private ?string $value;

    public function __construct()
    {
        $this->value = null;
    }

    public function sameAs(ValueObject $other): bool
    {
        return $other instanceof static
            && $other->toString() === $this->toString();
    }

    public static function fromString(string $value): static
    {
        $self = new self();
        $self->value = $value;
        return $self;
    }

    public function toString(): ?string
    {
        return $this->value;
    }

    public function isEmpty(): bool
    {
        return $this->value === '' || $this->value === null;
    }
}