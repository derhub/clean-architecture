<?php

namespace Derhub\Shared\Database\Doctrine\Types;

use Derhub\Shared\Values\ValueObjectStr;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;

trait DbalTyping
{
    abstract public function convertFromRaw(mixed $value): mixed;

    public function convertToDatabaseValue($value, ?AbstractPlatform $platform)
    {
        if ($value === null || $value === '') {
            return $this->defineEmptyValueForDB($value);
        }

        if (! is_object($value)) {
            return $value;
        }

        $class = $this->defineClass();
        if ($value::class !== $class) {
            throw ConversionException::conversionFailedInvalidType(
                $value,
                $class,
                [
                    $class,
                    ValueObjectStr::class,
                ]
            );
        }

        return $this->convertToRaw($value);
//        throw ConversionException::conversionFailed($value, 'string');
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === '' || $value === null) {
            return $this->defineEmptyValueForPHP($value);
        }

        $class = $this->defineClass();

        if (is_object($value) && $value::class === $class) {
            return $value;
        }

        return $this->convertFromRaw($value);
    }

    abstract public function convertToRaw(mixed $value): mixed;

    /**
     * @template T
     * @return class-string<T>
     */
    abstract public function defineClass(): string;

    /**
     * Use when convertToDatabaseValue
     * @param $value
     * @return mixed
     */
    public function defineEmptyValueForDB($value): mixed
    {
        return null;
    }

    abstract public function defineEmptyValueForPHP(mixed $value): mixed;

    abstract public function defineName(): string;
    public function getName(): string
    {
        return $this->defineName();
    }
}
