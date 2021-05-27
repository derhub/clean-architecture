<?php

namespace Derhub\Shared\MessageOutbox;

use Derhub\Shared\Utils\Uuid;
use Derhub\Shared\Values\ValueObjectStr;

class OutboxMessageId implements ValueObjectStr
{
    private ?string $value;

    public function __construct()
    {
        $this->value = null;
    }


    public function __toString()
    {
        return 'outbox message id: '.$this->toString();
    }

    public function sameAs(ValueObject $other): bool
    {
        return $other instanceof self
            && $this->toString() === $other->toString();
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

    public static function generate(): self
    {
        return self::fromString(Uuid::generate()->toString());
    }
}