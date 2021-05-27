<?php

namespace Derhub\Integration\Mapper;

class ExtractorCacheHelper
{
    private array $cache;
    /**
     * @var callable|null
     */
    private $propertyNameConverter;

    public function __construct(?callable $propertyNameConverter = null)
    {
        $this->propertyNameConverter = $propertyNameConverter;
        $this->cache = [];
    }

    public function extract(string $name, mixed ...$callbackParams): ?string
    {
        if (isset($this->cache[$name])) {
            return $this->cache[$name];
        }

        $result = $this->propertyNameConverter
            ? ($this->propertyNameConverter)($name, ...$callbackParams)
            : null;
        $this->cache[$name] = $result;
        return $result;
    }
}