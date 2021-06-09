<?php

namespace Derhub\BusinessManagement\Business\Model\Values;

use Derhub\BusinessManagement\Business\Shared\BoardingStatusValues;
use Derhub\Shared\Utils\Assert;
use Derhub\Shared\Values\ValueObject;
use Derhub\Shared\Values\ValueObjectInt;

class OnBoardStatus implements ValueObjectInt
{
    public const STATUES = [
        BoardingStatusValues::START,
        BoardingStatusValues::IN_PROGRESS,
        BoardingStatusValues::FINISH,
        BoardingStatusValues::APPROVED,
    ];

    private int $value;

    public static function start(): self
    {
        return self::init(BoardingStatusValues::START);
    }

    public static function inProgress(): self
    {
        return self::init(BoardingStatusValues::IN_PROGRESS);
    }

    public static function finish(): self
    {
        return self::init(BoardingStatusValues::FINISH);
    }

    public static function approved(): self
    {
        return self::init(BoardingStatusValues::APPROVED);
    }

    public static function fromInt(int $value): self
    {
        return self::init($value);
    }

    private static function init(int $value): self
    {
        Assert::inArray($value, self::STATUES);

        $self = new self();
        $self->value = $value;

        return $self;
    }

    public function __construct()
    {
        $this->value = BoardingStatusValues::START;
    }

    public function __toString()
    {
        return sprintf('business on-boarding status %s', $this->toInt());
    }

    public function isStarted(): bool
    {
        return $this->value === BoardingStatusValues::START;
    }

    public function isInProgress(): bool
    {
        return $this->value === BoardingStatusValues::IN_PROGRESS;
    }

    public function isFinish(): bool
    {
        return $this->value === BoardingStatusValues::FINISH;
    }

    public function sameAs(ValueObject $other): bool
    {
        return $other instanceof self
            && $other->toInt() === $this->toInt();
    }

    public function toInt(): int
    {
        return $this->value;
    }
}
