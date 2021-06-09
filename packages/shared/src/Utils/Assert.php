<?php

namespace Derhub\Shared\Utils;

use Assert\Assertion as BaseAssertion;
use Derhub\Shared\Exceptions\AssertionFailedException;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberUtil;

use function sprintf;

class Assert extends BaseAssertion
{
    protected static $exceptionClass = AssertionFailedException::class;

    public static function country(
        string $alpha2,
        ?string $message = null,
        string $propertyPath = null
    ): void {
        self::inArray($alpha2, CountryLookup::keys(), $message, $propertyPath);
    }

    public static function phone(
        string $value,
        ?string $countryCode = null,
        ?string $message = null,
        string $propertyPath = null
    ): bool {
        $phoneUtil = PhoneNumberUtil::getInstance();

        try {
            /** @var ?PhoneNumber $number */
            $number = $phoneUtil->parse($value, $countryCode);
            if (! $number) {
                $isValid = false;
            } elseif ($countryCode) {
                $isValid = $phoneUtil->isValidNumberForRegion(
                    $number,
                    $countryCode
                );
            } else {
                $isValid = $phoneUtil->isValidNumber($number);
            }
        } catch (NumberParseException $_) {
            $isValid = false;
        }

        if (! $isValid) {
            $message = sprintf(
                static::generateMessage(
                    $message ?: 'Value "%s" is not a valid phone number.'
                ),
                static::stringify($value),
            );

            throw static::createException(
                value: $value,
                message: $message,
                code: self::INVALID_STRING,
                propertyPath: $propertyPath
            );
        }

        return true;
    }

    public static function slug(
        array|string $slugs,
        int $minLength = 3,
        int $maxLength = 63,
        ?string $message = null,
        string $propertyPath = null
    ): void {
        if (! is_array($slugs)) {
            $slugs = [$slugs];
        }

        foreach ($slugs as $value) {
            self::betweenLength(
                $value,
                $minLength,
                $maxLength,
                $message,
                $propertyPath,
            );

            $isValidPattern = preg_match(
                '/^[A-Za-z0-9](?:[A-Za-z0-9\-]{0,61}[A-Za-z0-9])?$/',
                $value,
            );

            if ($isValidPattern) {
                continue;
            }

            if (! $isValidPattern || ReservedWords::isReserved($value)) {
                $message ??= "Value '$value' is not a valid slug.";
            }

            throw static::createException(
                value: $value,
                message: $message,
                code: self::INVALID_STRING,
                propertyPath: $propertyPath
            );
        }
    }
}
