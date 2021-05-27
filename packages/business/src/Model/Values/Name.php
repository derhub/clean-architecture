<?php

namespace Derhub\Business\Model\Values;

use Derhub\Shared\Model\ValueObject;
use Derhub\Shared\Model\ValueObject\ValueObjectStr;
use Derhub\Shared\Utils\Assert;

class Name implements ValueObjectStr
{
    private ?string $value;

    public function __construct()
    {
        $this->value = null;
    }

    private static function init(string $value): self
    {
        Assert::maxLength($value, 100);

        $self = new self();
        $self->value = $value;
        return $self;
    }

    public function __toString(): string
    {
        return 'business name ' . $this->value ?? '';
    }

    public function value(): ?string
    {
        return $this->value;
    }

    public function sameAs(ValueObject $other): bool
    {
        return $other instanceof static
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

    public function isEmpty(): bool
    {
        return empty($this->value);
    }
}
