<?php

namespace Derhub\Shared\Utils;

class ClassName
{
    public static function for(string $class): string
    {
        $array = explode('\\', $class);

        return end($array);
    }
}
