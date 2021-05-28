<?php

namespace Derhub\Shared\Database\Doctrine\Types;

use Doctrine\DBAL\Types\StringType;
use Derhub\Shared\Values\Email;

class EmailType extends StringType
{
    use DbalTyping;

    public const NAME = 'email';

    public function defineName(): string
    {
        return self::NAME;
    }

    public function defineClass(): string
    {
        return Email::class;
    }

    public function convertToRaw(mixed $value): string
    {
        return $value->toString();
    }

    public function defineEmptyValueForPHP($value): Email
    {
        return new Email();
    }

    public function convertFromRaw(mixed $value): Email
    {
        return Email::fromString($value);
    }
}
