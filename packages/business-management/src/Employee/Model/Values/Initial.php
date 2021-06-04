<?php

namespace Derhub\BusinessManagement\Employee\Model\Values;

use Derhub\Shared\Values\ValueObject;
use Derhub\Shared\Values\ValueObjectStr;

class Initial implements ValueObjectStr
{
    private ?string $value;

    public function __construct()
    {
        $this->value = null;
    }

    private static function init(string $value): self
    {
        $self = new self();
        $self->value = $value;
        return $self;
    }

    public function isEmpty(): bool
    {
        return empty($this->value);
    }

    public function __toString()
    {
        if ($this->isEmpty()) {
            return 'empty business employee initial';
        }

        return 'business employee initial: '.$this->toString();
    }

    public function sameAs(ValueObject $other): bool
    {
        return $other instanceof self
            && $other->toString() === $this->toString();
    }

    public static function fromString(string $value): self
    {
        return self::init($value);
    }

    public function toString(): ?string
    {
        return $this->value;
    }
}