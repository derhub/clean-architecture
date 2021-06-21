<?php

namespace Derhub\Shared\Database\Doctrine;

class DoctrineXmlMetadataRegistry
{
    private static array $metadata = [];

    public static function addPath(string $path): void
    {
        self::$metadata[$path] = $path;
    }

    public static function metadata(): array
    {
        return self::$metadata;
    }
}