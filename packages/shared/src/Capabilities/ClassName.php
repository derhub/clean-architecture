<?php

namespace Derhub\Shared\Capabilities;

class ClassName
{
    public static function for(string $class): string
    {
        $array = explode('\\', $class);

        return end($array);
    }
}
