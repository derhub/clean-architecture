<?php

namespace Derhub\IdentityAccess\Account\Infrastructure\Database\Doctrine\Types;

use Derhub\Shared\Database\Doctrine\Types\DbalTyping;

trait WithStringTyping
{
    use DbalTyping;

//    public const NAME = 'user_account_role';

    public function convertFromRaw(mixed $value): mixed
    {
        /** @var \Derhub\Shared\Values\ValueObjectStr $class */
        $class = $this->defineClass();
        return $class::fromString($value);
    }

    public function convertToRaw(mixed $value): mixed
    {
        return $value->toString();
    }

    public function defineEmptyValueForPHP(mixed $value): mixed
    {
        $class = $this->defineClass();
        return new $class();
    }

    public function defineName(): string
    {
        return static::NAME;
    }
}