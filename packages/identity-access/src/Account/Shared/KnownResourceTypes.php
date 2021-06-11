<?php

namespace Derhub\IdentityAccess\Account\Shared;

class KnownResourceTypes
{
    public const ROUTE = 'route';

    public const URL = 'url';
    public const URL_PATH = 'url_path';

    public const PERMISSION = 'permission';

    public const MULTI = 'multi';
    public const MULTI_KEY_TYPE = 'type';
    public const MULTI_KEY_VALUE = 'value';

    public static function all(): array
    {
        return [
            static::ROUTE,
            static::URL,
            static::URL_PATH,
            static::ROLE,
            static::PERMISSION,
            static::MULTI,
        ];
    }
}