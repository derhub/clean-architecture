<?php

namespace App\Actions;

use Derhub\Shared\Message\Command\CommandResponse;
use Derhub\Shared\Message\Query\QueryResponse;

class ApiResponseFactory
{
    public function create(): ApiResponse
    {
        return new ApiResponse([]);
    }

    public static function fromCommand(
        CommandResponse $response
    ): ApiResponse {
        return ApiResponse::create(
            [
                'aggregate_id' => $response->aggregateRootId(),
            ]
        );
    }

    public static function fromQuery(
        QueryResponse $response,
    ): ApiResponse {
        return ApiResponse::create(
            $response->results(),
        );
    }
}