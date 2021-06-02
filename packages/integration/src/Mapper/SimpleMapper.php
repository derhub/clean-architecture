<?php

namespace Derhub\Integration\Mapper;

use Derhub\Shared\ObjectMapper\ObjectMapperInterface;
use Derhub\Shared\Utils\Str;

class SimpleMapper implements ObjectMapperInterface
{
    /**
     * @var \Derhub\Integration\Mapper\ExtractorCacheHelper
     */
    private ExtractorCacheHelper $converter;

    public function __construct(?callable $propertyNameConverter = null)
    {
        $this->converter = new ExtractorCacheHelper(
            function (string $propertyName, ?string $convertType = null) use (
                $propertyNameConverter
            ) {
                if ($propertyNameConverter) {
                    return $propertyNameConverter($propertyName);
                }

                return match ($convertType) {
                    'extract' => Str::snakeCase($propertyName),
                    'transform' => Str::camelCase($propertyName),
                    null => $propertyName,
                };
            }
        );
    }

    public function extract(object $object): array
    {
        $extractor = new ObjectPropertyExtractor($this->converter);

        return $extractor->extract($object);
    }

    public function transform(object|array $data, string $object): mixed
    {
        if (is_object($data) && $data::class === $object) {
            return $data;
        }

        $converted = [];
        foreach ($data as $key => $value) {
            $propName = $this->converter->extract($key, 'transform');
            $converted[$propName] = $value;
        }


        return new $object(...$converted);
    }
}
