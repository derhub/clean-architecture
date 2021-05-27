<?php

namespace Derhub\Integration\Mapper;

use Throwable;

class InvalidTypeException extends \RuntimeException
{
    public function __construct(
        public string $name,
        string $message = "",
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public static function missingResolver(string $name, string $resolver): self
    {
        return new self(
            name: $name,
            message: sprintf(
                'invalid resolver "%s" for "%s"',
                $resolver,
                $name,
            ),
        );
    }

    public static function missingConstructor(string $object): self
    {
        return new self(
            name: $object,
            message: sprintf(
                '__constructor is not found in %s',
                $object
            ),
        );
    }

    public static function notSupportedResolver(
        string $name,
        mixed $resolver
    ) {
        $value = '';
        if (is_array($resolver)) {
            $value = implode(',', $resolver);
        }
        return new self(
            name: $name,
            message: sprintf(
                'field (%s) resolver is not supported %s',
                $name,
                $value
            ),
        );
    }

    public static function unableToResolveProperty(string $property): self
    {
        return new self(
            name: $property,
            message: sprintf(
                'unable to resolve field (%s)',
                $property,
            ),
        );
    }

    public static function autoResolveUnionTypeNoSupported(string $property): self
    {
        return new self(
            name: $property,
            message: sprintf(
                'auto resolving %s with union type is not supported.',
                $property,
            ),
        );
    }
}
