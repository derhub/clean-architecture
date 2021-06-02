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

    private static ?DateTimeLiteral $freeze = null;
    private static string $tz = 'utc';

    private ?DateTimeImmutable $value;

    /**
     * Create date with empty value
     * @return $this
     */
    public static function createEmpty(): self
    {
        return new self();
    }

    public static function freezeAt(DateTimeLiteral $dateTime): void
    {
        static::$freeze = $dateTime;
    }

    public static function fromFormat(string $format, string $value): self|null
    {
        $date = DateTimeImmutable::createFromFormat($format, $value);
        if (! $date) {
            throw new DomainException('Invalid date format');
        }

        return static::init($date);
    }

    public static function fromString(string $value): self
    {
        return self::fromFormat(self::$defaultFormat, $value);
    }

    public static function fromTimestamp(int $timestamp): self
    {
        return static::init(new DateTimeImmutable('@'.$timestamp));
    }

    private static function init(DateTimeImmutable $datetime): static
    {
        $self = new static();
        $self->value = static::$freeze?->rawValue() ?? $datetime;

        return $self;
    }

    public static function isValidWithFormat(
        string $value,
        ?string $format = null,
    ): bool {
        $format = $format ?? self::$defaultFormat;
        $dateTime = DateTimeImmutable::createFromFormat('!'.$format, $value);

        return $dateTime !== false && $value === $dateTime->format($format);
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

    public static function unFreeze(): void
    {
        static::$freeze = null;
    }

    public function __construct()
    {
        $this->value = null;
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

    public function rawValue(): ?DateTimeImmutable
    {
        return $this->value;
    }

    public function sameAs(ValueObject $other): bool
    {
        return $other instanceof static &&
            $this->rawValue() === $other->rawValue();
    }

    public function timestamp(): int
    {
        return $this->value->getTimestamp();
    }

    public function toString(): ?string
    {
        return $this->iso8601();
    }
}
