<?php

namespace Derhub\Shared\Capabilities;

class ClassNameCapability
{
    public static function name(string $class): string
    {
        $array = explode('\\', $class);
        return end($array);
    }
}