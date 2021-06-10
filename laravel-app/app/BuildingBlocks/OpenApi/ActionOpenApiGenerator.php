<?php

namespace App\BuildingBlocks\OpenApi;

use App\BuildingBlocks\Actions\Action;
use App\BuildingBlocks\Actions\Field;
use App\BuildingBlocks\Actions\Fields\ArrayField;
use cebe\openapi\spec\Operation;
use cebe\openapi\spec\Parameter;
use cebe\openapi\spec\PathItem;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Responses;
use cebe\openapi\spec\Schema;

use Derhub\Shared\Utils\ClassName;

class ActionOpenApiGenerator
{
    public function __construct(private Action|string $action)
    {
    }

    private function getParameterType(bool $isArray, Field $config): Schema
    {
        [
            'required' => $required,
            'types' => $types,
            'default' => $default,
        ] = $config->all();

        $schema = [];

        $phpTypeToOpenApi = [
            'int' => 'integer',
            'bool' => 'boolean',
            'string' => 'string',
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

    public function openApiParameters(): array
    {
        $parameters = [];
        /** @var \App\BuildingBlocks\Actions\Field $config */
        foreach ($this->action::getComputedFields() as $field => $config) {
            [
                'types' => $types,
                'alias' => $alias,
                'required' => $required,
            ] = $config->all();

            $hidden = $config->hidden();
            if ($hidden) {
                continue;
            }

            $fieldName = $alias;
            $inPath = str_contains($this->action::getRoutePath(), $field) ||
                str_contains($this->action::getRoutePath(), $alias);

            $isArray = ! $inPath && in_array('array', $types, true);

            $parameter = array_merge(
                [
                    'name' => $fieldName.($isArray ? '[]' : ''),
                    'in' => $inPath ? 'path' : 'query',
                    'schema' => $this->getParameterType($isArray, $config),
                    'required' => $required,
                    'allowEmptyValue' => in_array('null', $types, true),
                    'description' => $config['description'] ?? '',
                ],
                $config->openApiParameter()
            );

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

    public function openApiPathItem(): PathItem
    {
        return new PathItem(
            [
                $this->action::getRouteMethod() => new Operation(
                    [
                        'tags' => [$this->action::getModuleId()],
                        'operationId' => ClassName::for(
                            \is_object($this->action)
                                ? $this->action::class
                                : $this->action
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
                'parameters' => $this->openApiParameters(),
            ]
        );
    }

    /**
     * @throws \cebe\openapi\exceptions\TypeErrorException
     */
    public function openApiSchema(): Schema
    {
        $required = [];
        $properties = [];
        /** @var \App\BuildingBlocks\Actions\Field $config */
        foreach ($this->action::getComputedFields() as $field => $config) {
            if ($config->required()) {
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
