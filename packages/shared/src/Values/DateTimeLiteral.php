<?php

namespace Derhub\Shared\Values;

use DateTimeImmutable;
use DateTimeZone;
use DomainException;

class DateTimeLiteral implements ValueObjectStr
{
    /**
     * format: ISO8601
     */
    public static string $defaultFormat = 'Y-m-d\TH:i:sO';
    private static string $tz = 'utc';

    private static ?DateTimeLiteral $freeze = null;

    private ?DateTimeImmutable $value;

    public function __construct()
    {
        $this->value = null;
    }

    private static function init(DateTimeImmutable $datetime): static
    {
        $self = new static();
        $self->value = static::$freeze?->rawValue() ?? $datetime;
        return $self;
    }

    public function rawValue(): ?DateTimeImmutable
    {
        return $this->value;
    }

    public static function freezeAt(DateTimeLiteral $dateTime): void
    {
        static::$freeze = $dateTime;
    }

    public static function unFreeze(): void
    {
        static::$freeze = null;
    }

    public static function now(): DateTimeLiteral
    {
        return static::init(
            new DateTimeImmutable(
                date(self::$defaultFormat),
                new DateTimeZone(self::$tz)
            )
        );
    }

    public static function fromTimestamp(int $timestamp): self
    {
        return static::init(new DateTimeImmutable('@'.$timestamp));
    }

    public static function fromString(string $value): self
    {
        return self::fromFormat(self::$defaultFormat, $value);
    }

    public static function fromFormat(string $format, string $value): self|null
    {
        $date = DateTimeImmutable::createFromFormat($format, $value);
        if (! $date) {
            throw new DomainException('Invalid date format');
        }

        return static::init($date);
    }

    public static function isValidWithFormat(
        string $value,
        ?string $format = null,
    ): bool {
        $format = $format ?? self::$defaultFormat;
        $dateTime = DateTimeImmutable::createFromFormat('!'.$format, $value);

        return $dateTime !== false && $value === $dateTime->format($format);
    }

    public function timestamp(): int
    {
        return $this->value->getTimestamp();
    }

    public function sameAs(ValueObject $other): bool
    {
        return $other instanceof static &&
            $this->rawValue() === $other->rawValue();
    }

    public function __toString(): string
    {
        if ($this->value === null) {
            return '';
        }

        return $this->format(self::$defaultFormat);
    }

    public function format(string $format): ?string
    {
        return $this->value?->format($format) ?? null;
    }

    public function isEmpty(): bool
    {
        return empty($this->value);
    }

    public function iso8601(): ?string
    {
        return $this->format(self::$defaultFormat);
    }

    public function toString(): ?string
    {
        return $this->iso8601();
    }
}
