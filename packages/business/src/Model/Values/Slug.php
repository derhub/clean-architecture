<?php

namespace Derhub\Business\Model\Values;

use Derhub\Shared\Model\ValueObject;
use Derhub\Shared\Model\ValueObject\ValueObjectStr;
use Derhub\Shared\Utils\Assert;
use Derhub\Shared\Utils\Str;

class Slug implements ValueObjectStr
{
    private ?string $value;

    public function __construct()
    {
        $this->value = null;
    }

    private static function init(string $value): self
    {
        self::validate($value);

        $self = new self();
        $self->value = $value;
        return $self;
    }

    public function __toString()
    {
        return sprintf('business slug %s', $this->toString());
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

    public static function validate(string|array $value): bool
    {
        Assert::slug($value);
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

    public static function createFromString(string $string): self
    {
        return self::init(Str::slug($string));
    }
}