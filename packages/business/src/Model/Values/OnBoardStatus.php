<?php

namespace Derhub\Business\Model\Values;

use Derhub\Shared\Values;
use Derhub\Shared\Utils\Assert;
use Derhub\Shared\Values\ValueObject;
use Derhub\Shared\Values\ValueObjectInt;
use Derhub\Shared\Values\ValueObjectStr;

class OnBoardStatus implements
    ValueObjectStr,
    ValueObjectInt
{
    public const ONBOARD_OWNER = 2;
    public const ONBOARD_SALES = 1;
    public const NONE = 0;

    public const STATUES = [
        self::NONE => 'none',
        self::ONBOARD_SALES => 'onboard-sales',
        self::ONBOARD_OWNER => 'onboard-owner',
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
        return sprintf('business on-boarding status %s', $this->toString());
    }

    public static function fromInt(int $value): self
    {
        return self::init($value);
    }

    public function toInt(): int
    {
        return $this->value;
    }

    public function isSales(): bool
    {
        return $this->value === self::ONBOARD_SALES;
    }

    public static function bySales(): self
    {
        return self::init(self::ONBOARD_SALES);
    }

    public function isOwner(): bool
    {
        return $this->value === self::ONBOARD_OWNER;
    }

    public static function byOwner(): self
    {
        return self::init(self::ONBOARD_OWNER);
    }
}
