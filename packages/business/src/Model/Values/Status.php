<?php

namespace Derhub\Business\Model\Values;

use Derhub\Shared\Utils\Assert;
use Derhub\Shared\Values\ValueObject;
use Derhub\Shared\Values\ValueObjectInt;
use Derhub\Shared\Values\ValueObjectStr;

class Status implements ValueObjectInt, ValueObjectStr
{
    public const DISABLED = 0;
    public const ENABLED = 1;

    public static array $statusNames = [
        self::ENABLED => 'enabled',
        self::DISABLED => 'disabled',
    ];

    private int $value;

    public function __construct()
    {
        $this->value = self::ENABLED;
    }

    private static function init(int $value): self
    {
        Assert::keyExists(self::$statusNames, $value);

        $self = new self();
        $self->value = $value;
        return $self;
    }

    public static function disable(): self
    {
        return self::init(self::DISABLED);
    }

    public static function enable(): self
    {
        return self::init(self::ENABLED);
    }

    public function sameAs(ValueObject $other): bool
    {
        return $other instanceof self
            && $other->toInt() === $this->toInt();
    }

    public static function fromString(string $value): self
    {
        Assert::inArray($value, self::$statusNames, 'Invalid status');

        /** @var int $intVal */
        $intVal = array_search($value, self::$statusNames, true);
        return self::init($intVal);
    }

    public function toString(): string
    {
        return self::$statusNames[$this->value];
    }

    public function __toString(): string
    {
        return sprintf('business status is %s', $this->toString());
    }

    public function isEnable(): bool
    {
        return $this->value === self::ENABLED;
    }

    public function isDisabled(): bool
    {
        return $this->value === self::DISABLED;
    }

    public static function fromInt(int $value): self
    {
        return self::init($value);
    }

    public function toInt(): int
    {
        return $this->value;
    }
}
