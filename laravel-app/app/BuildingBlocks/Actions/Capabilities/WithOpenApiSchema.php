<?php

namespace App\BuildingBlocks\Actions\Capabilities;

/**
 * Converts fields to Open api schema using cebe/php-openapi
 */
trait WithOpenApiSchema
{
    /**
     * @throws \cebe\openapi\exceptions\TypeErrorException
     */
    public static function openApiSchema(): \cebe\openapi\spec\Schema
    {
        $required = [];
        $properties = [];
        foreach (static::fields([]) as $field => $config) {
            ['required' => $isRequired] = $config;
            if ($isRequired) {
                $required[] = $field;
            }
        }

        return new \cebe\openapi\spec\Schema(
            [
                'type' => 'object',
                'required' => $required,
                'properties' => $properties,
            ]
        );
    }

    public static function openApiPathItem(): \cebe\openapi\spec\PathItem
    {
        return new \cebe\openapi\spec\PathItem(
            [
                static::ROUTE_METHOD => new \cebe\openapi\spec\Operation(
                    [
                        'tags' => [static::MODULE],
                        // 'operationId' => self::class,
                        'responses' => new \cebe\openapi\spec\Responses(
                            [
                                '2XX' => new \cebe\openapi\spec\Reference(
                                    ['$ref' => '#/components/responses/2XX']
                                ),
                                '4XX' => new \cebe\openapi\spec\Reference(
                                    ['$ref' => '#/components/responses/4XX']
                                ),
                            ]
                        ),
                    ]
                ),
                'parameters' => self::openApiParameters(),
            ]
        );
    }

    public static function openApiParameters(): array
    {
        $parameters = [];
        foreach (static::fields([]) as $field => $config) {
            [
                'types' => $types,
                'alias' => $alias,
                'required' => $required,
            ] = $config;

            $hidden = $config['hidden'] ?? false;
            if ($hidden) {
                continue;
            }

            $fieldName = $alias;
            $inPath = \str_contains(static::ROUTE, $field);
            if ($inPath) {
                $fieldName = $field;
            }
            $isArray = ! $inPath && \in_array('array', $types, true);
            $parameter = [
                'name' => $fieldName.($isArray ? '[]' : ''),
                'in' => $inPath ? 'path' : 'query',
                'schema' => self::guessParameterType($isArray, $config),
                'required' => $required,
                'allowEmptyValue' => \in_array('null', $types, true),
                'description' => $config['description'] ?? '',
            ];

            $deprecated = $config['deprecated'] ?? false;
            if ($deprecated) {
                $parameter['deprecated'] = $deprecated;
            }

            if (! $inPath && $isArray) {
                $parameter['style'] = 'form';
                $parameter['explode'] = true;
                $parameter['allowReserved'] = true;
            }

            $parameters[] = new \cebe\openapi\spec\Parameter($parameter);
        }

        return $parameters;
    }

    private static function guessParameterType(
        bool $isArray,
        array $config
    ): \cebe\openapi\spec\Schema {
        $schema = [];

        [
            'required' => $required,
            'types' => $types,
            'default' => $default,
        ] = $config;

        $noneNullType = 'string'; // unknown types is already string
        foreach ($types as $val) {
            if ($val === 'array' || $val === 'null') {
                continue;
            }
            $noneNullType = $val;
        }

        $schema['type'] = $isArray ? 'array' : $noneNullType;
        if ($isArray) {
            $itemsSchema = [
                'type' => $noneNullType,
            ];

            $schema['items'] =
                new \cebe\openapi\spec\Schema($itemsSchema);
        }

        if (! $required && $default !== null) {
            $schema['default'] = $default;
        }

        if ($default === null && ! $required) {
            $schema['nullable'] = true;
        }

        $options = $config['options'] ?? [];
        if (! empty($options)) {
            $schema['enum'] = $options;
        }

        return new \cebe\openapi\spec\Schema($schema);
    }
}