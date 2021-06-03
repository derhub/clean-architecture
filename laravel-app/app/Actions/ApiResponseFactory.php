<?php

namespace App\Actions;

use Derhub\Shared\Message\Command\CommandResponse;
use Derhub\Shared\Message\Query\QueryResponse;

class ApiResponseFactory
{
    public static function create(null|CommandResponse|QueryResponse $response): ApiResponse
    {
        return new ApiResponse($response);
    }

    public static function fromCommand(
        CommandResponse $response
    ): ApiResponse {
        return new ApiResponse($response);
    }

    public static function fromQuery(
        QueryResponse $response,
    ): ApiResponse {
        return new ApiResponse($response);
    }
}