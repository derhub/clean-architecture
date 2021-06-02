<?php

namespace Derhub\Shared\Values;

use Derhub\Shared\Utils\CountryLookup;

abstract class Country implements ValueObjectStr
{
    private array $value;

    public function __construct()
    {
        $this->value = [];
    }

    public function __toString(): string
    {
        if ($this->isEmpty()) {
            return 'no country';
        }

        return 'country name: '.$this->name();
    }

    public function sameAs(ValueObject $other): bool
    {
        return $other instanceof static
            && $other->toString() === $this->toString();
    }

    public static function validate(string $value): bool
    {
        return true;
    }

    public static function fromString(string $value): static
    {
        return static::fromAlpha2($value);
    }

    public static function fromAlpha2(string $value): static
    {
        $data = CountryLookup::fromAlpha2($value);
        $self = new static();
        $self->value = $data;

        return $self;
    }

    public function toString(): ?string
    {
        return $this->alpha2();
    }

    public function isEmpty(): bool
    {
        return empty($this->value);
    }

    public function currency(): ?array
    {
        return $this->value[CountryLookup::KEY_CURRENCY] ?? null;
    }

    public function name(): ?string
    {
        return $this->value[CountryLookup::KEY_NAME] ?? null;
    }

    public function alpha2(): ?string
    {
        return $this->value[CountryLookup::KEY_ALPHA2] ?? null;
    }

    public function alpha3(): ?string
    {
        return $this->value[CountryLookup::KEY_ALPHA3] ?? null;
    }

    public function numeric(): ?int
    {
        return $this->value[CountryLookup::KEY_NUMERIC] ?? null;
    }
}
