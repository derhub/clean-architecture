<?php

namespace Derhub\BusinessManagement\Employee\Infrastructure\Database\Doctrine;

use Derhub\Shared\Database\Doctrine\Types\DbalTyping;

trait DbTypeBytes
{
    use DbalTyping;

    public function convertFromRaw(mixed $value): mixed
    {
        /** @var \Derhub\Shared\Values\UuidValueObject $class */
        $class = $this->defineClass();
        return $class::fromBytes($value);
    }

    public function convertToRaw(mixed $value): mixed
    {
        return $value->toBytes();
    }

    /**
     * @return class-string
     */
    abstract public function defineClass(): string;

    public function defineEmptyValueForPHP(mixed $value): mixed
    {
        $class = $this->defineClass();
        return new $class;
    }
}