<?php

namespace Derhub\BusinessManagement\Business\Model\Values;

use Derhub\BusinessManagement\Business\Model\Exception\InvalidNameException;
use Derhub\Shared\Exceptions\DomainException;
use Derhub\Shared\Values\ValueObject;
use Derhub\Shared\Values\ValueObjectStr;
use Derhub\Shared\Utils\Assert;

class Name implements ValueObjectStr
{
    public const MAX_LENGTH = 100;

    private ?string $value;

    public static function fromString(string $value): self
    {
        return self::init($value);
    }

    private static function init(string $value): self
    {
        try {
            Assert::notEmpty($value);
            Assert::maxLength($value, self::MAX_LENGTH);

            $self = new self();
            $self->value = $value;

            return $self;
        } catch (DomainException $e) {
            throw InvalidNameException::fromException($e);
        }
    }

    public function __construct()
    {
        $this->value = null;
    }

    public function __toString(): string
    {
        return 'business name '.$this->value ?? '';
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

    public function value(): ?string
    {
        return $this->value;
    }
}
