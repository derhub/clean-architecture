<?php

namespace App\BuildingBlocks\Actions\Capabilities;

use cebe\openapi\spec\Operation;
use cebe\openapi\spec\Parameter;
use cebe\openapi\spec\PathItem;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Responses;
use cebe\openapi\spec\Schema;
use Derhub\Shared\Utils\ClassName;

/**
 * Converts fields to Open api schema using cebe/php-openapi
 * To overwrite open api parameter override the method defineParameters()
 */
trait WithOpenApiSchema
{
    /**
     * example:
     * [
     *  .....
     *  'fieldNameHere' => new Schema([
     *      'type' => 'array',
     *      'items' => new Schema(['type' => 'object'])
     *  ])
     * ]
     */
    public static function defineParameters(): array
    {
        return [];
    }

    private static function guessParameterType(
        bool $isArray,
        array $config
    ): Schema {
        [
            'required' => $required,
            'types' => $types,
            'default' => $default,
        ] = $config;

        $schema = [];

        $phpTypeToOpenApi = [
            'int' => 'integer',
            'bool' => 'boolean',
        ];
        $noneNullType = 'string'; // default type string
        foreach ($types as $val) {
            if ($val === 'array' || $val === 'null') {
                continue;
            }
            $noneNullType = $phpTypeToOpenApi[$val] ?? $val;
        }

        $schema['type'] = $isArray ? 'array' : $noneNullType;
        if ($isArray) {
            $itemsSchema = [
                'type' => $noneNullType,
            ];

            $schema['items'] =
                new Schema($itemsSchema);
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

        return new Schema($schema);
    }

    public static function openApiParameters(): array
    {
        $definedFieldParameters = self::defineParameters();
        $parameters = [];
        foreach (static::fields() as $field => $config) {
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
            $inPath = str_contains(static::ROUTE, $field);
            if ($inPath) {
                $fieldName = $field;
            }
            $isArray = ! $inPath && in_array('array', $types, true);
            $parameter = [
                'name' => $fieldName.($isArray ? '[]' : ''),
                'in' => $inPath ? 'path' : 'query',
                'schema' => $definedFieldParameters[$field] ?? self::guessParameterType($isArray, $config),
                'required' => $required,
                'allowEmptyValue' => in_array('null', $types, true),
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

            $parameters[] = new Parameter($parameter);
        }

        return $parameters;
    }

    public static function openApiPathItem(): PathItem
    {
        return new PathItem(
            [
                static::ROUTE_METHOD => new Operation(
                    [
                        'tags' => [static::MODULE],
                        'operationId' => ClassName::for(
                            static::COMMAND_CLASS
                        ),
                        'responses' => new Responses(
                            [
                                '2XX' => new Reference(
                                    ['$ref' => '#/components/responses/2XX']
                                ),
                                '4XX' => new Reference(
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

    /**
     * @throws \cebe\openapi\exceptions\TypeErrorException
     */
    public static function openApiSchema(): Schema
    {
        $required = [];
        $properties = [];
        foreach (static::fields() as $field => $config) {
            ['required' => $isRequired] = $config;
            if ($isRequired) {
                $required[] = $field;
            }
        }

        return new Schema(
            [
                'type' => 'object',
                'required' => $required,
                'properties' => $properties,
            ]
        );
    }
}
