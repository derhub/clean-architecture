<?php
/**
 * Created By: Johnder Baul<imjohnderbaul@gmail.com>
 * Date: 3/28/21
 */

namespace Derhub\Shared\Utils;

use Symfony\Component\String\Inflector\EnglishInflector;
use Symfony\Component\String\Slugger\AsciiSlugger;

use function Symfony\Component\String\u;

class Str
{
    public static function camelCase(string $str): string
    {
        return u($str)->camel()->toString();
    }

    public static function camel(string $str): string
    {
        return self::camelCase($str);
    }

    public static function lower(string $str): string
    {
        return u($str)->lower()->toString();
    }

    public static function slug(string $name, string $locale = null): string
    {
        $slugger = new AsciiSlugger();

        if ($locale !== null) {
            $slugger->setLocale($locale);
        }

        return $slugger->slug($name)->lower()->toString();
    }

    public static function snakeCase(string $str): string
    {
        return u($str)->snake()->toString();
    }

    public static function snake(string $str): string
    {
        return self::snakeCase($str);
    }

    /**
     * Return array of plural version of string
     * @param string $str
     * @return array
     */
    public static function pluralize(string $str): array
    {
        $inflector = new EnglishInflector();
        return $inflector->pluralize($str);
    }

    /**
     * Return array of singular version of string
     * @param string $str
     * @return array
     */
    public static function singularize(string $str): array
    {
        $inflector = new EnglishInflector();
        return $inflector->singularize($str);
    }
}
