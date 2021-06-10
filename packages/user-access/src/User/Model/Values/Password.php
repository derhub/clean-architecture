<?php

namespace Derhub\UserAccess\User\Model\Values;

use Derhub\Shared\Values\ValueObject;

class Password
{
    private ?string $value;

    public function __construct()
    {
        $this->value = null;
    }

    public function __toString()
    {
        if ($this->isEmpty()) {
            return 'empty user password';
        }

        return 'user password [private]';
    }

    public function sameAs(ValueObject $other): bool
    {
        return $other instanceof self
            && $other->toString() === $this->toString();
    }

    public static function fromString(string $value): self
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