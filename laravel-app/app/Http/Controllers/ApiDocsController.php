<?php

namespace App\Http\Controllers;

use App\BuildingBlocks\OpenApi\ActionOpenApiGenerator;
use cebe\openapi\spec\Components;
use cebe\openapi\spec\Example;
use cebe\openapi\spec\MediaType;
use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Response;
use cebe\openapi\spec\Schema;
use cebe\openapi\spec\Server;
use cebe\openapi\Writer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Symfony\Component\Finder\Finder;

class ApiDocsController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $openApi = $this->createOpenApiObject();
        $apiJson = Writer::writeToJson($openApi);

        return JsonResponse::fromJsonString($apiJson);
    }

    public function validateOpenApi(): JsonResponse
    {
        $openApi = $this->createOpenApiObject();
        $openApi->validate();
        $errors = $openApi->getErrors();

        return new JsonResponse(data: $errors);
    }

    public function swaggerUI(): View
    {
        return view('swagger-ui');
    }

    private function createOpenApiObject(): OpenApi
    {
        $paths = $this->findPathsFromActions();

        return new OpenApi(
            [
                'openapi' => '3.0.2',
                'info' => [
                    'title' => 'Clean Architecture API',
                    'version' => '0.0.1',
                ],
                'servers' => [
                    new Server(
                        [
                            'url' => 'http://127.0.0.1:8000',
                            'description' => 'Local server',
                        ]
                    ),
                ],
                'components' => new Components(
                    [
                        'responses' =>
                            $this->openApiResponseSchemas(),
                    ]
                ),
                'paths' => $paths,
            ]
        );
    }

    private function findPathsFromActions(): array
    {
        $actionFinder = (new Finder())
            ->in(base_path('app/Actions'))
            ->notPath(['#^Samples#'])
            ->name('*.php')
            ->notName('/Generated/')
            ->ignoreDotFiles(true)
        ;

        $paths = [];

        /** @var \Symfony\Component\Finder\SplFileInfo $info */
        foreach ($actionFinder->getIterator() as $info) {
            $className = '\App\\'.str_replace(
                [base_path('app').'/', '.php', '/'],
                ['', '', '\\'],
                $info->getRealPath()
            );

            if (class_exists($className, true)) {
                $action = new ActionOpenApiGenerator($className);
                $paths[$className::ROUTE] = $action->openApiPathItem();
            }
        }

        return $paths;
    }

    public function openApiResponseSchemas(): array
    {
        $errorSchema = new Schema(
            [
                'type' => 'array',
                'items' => new Schema(
                    [
                        'type' => 'object',
                        'properties' => [
                            'type' => new Schema(
                                [
                                    'type' => 'string',
                                    'enum' => [
                                        'validation',
                                        'exception',
                                        'authorization',
                                    ],
                                ]
                            ),
                            'field' => new Schema(
                                ['type' => 'string', 'nullable' => true]
                            ),
                            'message' => new Schema(
                                ['type' => 'string']
                            ),
                        ],

                    ]
                ),
            ]
        );

        $defaultSchema = new Schema(
            [
                'type' => 'object',
                'properties' => [
                    'status' => new Schema(
                        [
                            'type' => 'integer',
                            'enum' => [200, 404, 422, 500],
                        ]
                    ),
                    'data' => new Schema(
                        [
                            'type' => 'array',
                            'items' => new Schema(['type' => 'object']),
                        ]
                    ),
                    'success' => new Schema(
                        ['type' => 'boolean']
                    ),
                    'errors' => $errorSchema,
                ],
            ]
        );

        return [
            '2XX' => new Response(
                [
                    'description' => 'SUCCESS',
                    'content' => [
                        'application/json' => new MediaType(
                            [
                                'schema' => $defaultSchema,
                                'examples' => $this->responseExample(),
                            ]
                        ),
                    ],
                ]
            ),
            '4XX' => new Response(
                [
                    'description' => 'FAILED',
                    'content' => [
                        'application/json' => new MediaType(
                            [
                                'schema' => $defaultSchema,
                                'examples' => $this->errorExamples(),
                            ]
                        ),
                    ],
                ]
            ),
        ];
    }

    private function errorExamples()
    {
        return [
            'validation 4xx' => new Example(
                [
                    'value' => [
                        'status' => 422,
                        'data' => [],
                        'errors' => [
                            [
                                'type' => 'validation',
                                'field' => 'string',
                                'message' => 'string',
                            ],
                        ],
                        'success' => false,
                    ],
                ]
            ),
            'validation exception 4xx' => new Example(
                [
                    'value' => [
                        'status' => 422,
                        'data' => [],
                        'errors' => [
                            [
                                'type' => 'exception',
                                'field' => 'string',
                                'message' => 'string',
                            ],
                        ],
                        'success' => false,
                    ],
                ]
            ),
            'exception 5xx' => new Example(
                [
                    'value' => [
                        'status' => 500,
                        'data' => [],
                        'errors' => [
                            [
                                'type' => 'exception',
                                'field' => null,
                                'message' => 'string',
                            ],
                        ],
                        'success' => false,
                    ],
                ]
            ),
            'authorization 4xx' => new Example(
                [
                    'value' => [
                        'status' => 403,
                        'data' => [],
                        'errors' => [
                            [
                                'type' => 'authorization',
                                'field' => null,
                                'message' => 'string',
                            ],
                        ],
                        'success' => false,
                    ],
                ]
            ),
        ];
    }

    private function responseExample()
    {
        return [
            'POST' => new Example(
                [
                    'value' => [
                        'status' => 200,
                        'data' => [
                            ['aggregate_root_id' => "string"],
                        ],
                        'errors' => [],
                        'success' => true,
                    ],
                ]
            ),
            'GET' => new Example(
                [
                    'value' => [
                        'status' => 200,
                        'data' => [
                            [
                                'sample_filed' => 'sample field value 1',
                            ],
                            [
                                'sample_filed' => 'sample field value 2',
                            ],
                        ],
                        'errors' => [],
                        'success' => true,
                    ],
                ]
            ),
        ];
    }
}
