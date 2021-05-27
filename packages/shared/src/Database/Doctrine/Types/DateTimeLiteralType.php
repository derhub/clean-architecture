<?php

namespace Derhub\Shared\Database\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\DateTimeImmutableType;
use Derhub\Shared\Values\DateTimeLiteral;

class DateTimeLiteralType extends DateTimeImmutableType
{
    public const NAME = 'datetime_literal';

    public function getName(): string
    {
        return self::NAME;
    }

    public function convertEmptyToNull(): bool
    {
        return true;
    }

    public function getClass(): string
    {
        return DateTimeLiteral::class;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return $value;
        }

        if ($value === '' && $this->convertEmptyToNull()) {
            return null;
        }

        if ($value instanceof DateTimeLiteral) {
            return $value->format($platform->getDateTimeFormatString());
        }

        throw ConversionException::conversionFailedInvalidType(
            $value,
            $this->getName(),
            ['null', DateTimeLiteral::class]
        );
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null || $value === '') {
            return new DateTimeLiteral();
        }

        if ($value instanceof DateTimeLiteral) {
            return $value;
        }

        return DateTimeLiteral::fromFormat(
            $platform->getDateTimeFormatString(),
            $value
        );
    }
}
