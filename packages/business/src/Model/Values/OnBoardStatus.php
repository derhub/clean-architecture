<?php

namespace Derhub\Business\Model\Values;

use Derhub\Shared\Model\ValueObject;
use Derhub\Shared\Utils\Assert;

class OnBoardStatus implements
    ValueObject\ValueObjectStr,
    ValueObject\ValueObjectInt
{
    public const ONBOARD = 2;
    public const HANDED = 1;
    public const NONE = 0;

    public const STATUES = [
        self::HANDED => 'handed',
        self::NONE => 'none',
        self::ONBOARD => 'onboard',
    ];

    private int $value;

    public function __construct()
    {
        $this->value = self::NONE;
    }

    private static function init(int $value): self
    {
        Assert::keyExists(self::STATUES, $value);

        $self = new self();
        $self->value = $value;
        return $self;
    }

    public function sameAs(ValueObject $other): bool
    {
        return $other instanceof self
            && $other->toInt() === $this->toInt();
    }

    public static function fromString(string $value): self
    {
        Assert::inArray($value, self::STATUES);

        /** @var int $intVal */
        $intVal = array_search($value, self::STATUES, true);
        return self::init($intVal);
    }

    public function toString(): string
    {
        return self::STATUES[$this->value];
    }

    public function __toString()
    {
        return sprintf('business is %s', $this->toString());
    }

    public static function fromInt(int $value): self
    {
        return self::init($value);
    }

    public function toInt(): int
    {
        return $this->value;
    }

    public function isHanded(): bool
    {
        return $this->value === self::HANDED;
    }

    public static function handed(): self
    {
        return self::init(self::HANDED);
    }

    public static function notHanded(): self
    {
        return self::init(self::NONE);
    }

    public function isNotHanded(): bool
    {
        return $this->value === self::NONE;
    }

    public static function onBoard(): self
    {
        return self::init(self::ONBOARD);
    }

    public function isOnboard(): bool
    {
        return $this->value === self::ONBOARD;
    }
}
