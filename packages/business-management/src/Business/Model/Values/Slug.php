<?php

namespace Derhub\BusinessManagement\Business\Model\Values;

use Derhub\BusinessManagement\Business\Model\Exception\InvalidSlugException;
use Derhub\Shared\Exceptions\DomainException;
use Derhub\Shared\Utils\Assert;
use Derhub\Shared\Utils\Str;
use Derhub\Shared\Values\ValueObject;
use Derhub\Shared\Values\ValueObjectStr;

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
        return sprintf('business-management slug %s', $this->toString());
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
        try {
            Assert::slug($value);
        } catch (DomainException $e) {
            throw InvalidSlugException::fromException($e);
        }
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
