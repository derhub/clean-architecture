<?php

namespace Tests\Integration\Fixtures;

use Derhub\Shared\Values\ValueObject;
use Derhub\Shared\Values\ValueObjectStr;

class SimpleValueObjFixture implements ValueObjectStr
{
    private ?string $value;

    public function __construct()
    {
        $this->value = null;
    }

    public function __toString()
    {
        return 'its a simple value obj';
    }

    public function sameAs(ValueObject $other): bool
    {
        return $other instanceof self
            && $other->toString() && $this->toString();
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
}
