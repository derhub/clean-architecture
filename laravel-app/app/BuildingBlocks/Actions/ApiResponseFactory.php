<?php

namespace App\BuildingBlocks\Actions;

use Derhub\Shared\Message\Command\CommandResponse;
use Derhub\Shared\Message\Query\QueryResponse;
use Illuminate\Validation\Validator;

class ApiResponseFactory
{
    public static function create(
        null|CommandResponse|QueryResponse $response
    ): ApiMessageResponse {
        return new ApiMessageResponse($response);
    }

    public static function fromCommand(
        CommandResponse $response
    ): ApiMessageResponse {
        return new ApiMessageResponse($response);
    }

    public static function fromMessageResponse(
        CommandResponse|QueryResponse $response
    ): ApiMessageResponse {
        return new ApiMessageResponse($response);
    }

    public static function fromQuery(
        QueryResponse $response,
    ): ApiMessageResponse {
        return new ApiMessageResponse($response);
    }

    public static function fromValidation(
        Validator $validator
    ): ApiErrorResponse {
        $self = new ApiErrorResponse();
        $errors = [];
        foreach ($validator->errors()->toArray() as $field => $errMessage) {
            $errors[] = [
                'type' => 'validation',
                'field' => $field,
                'message' => $errMessage,
            ];
        }
        $self->setErrors($errors);

        return $self;
    }

    public static function fromException(
        \Throwable $e,
        string $moduleId = null
    ): ApiErrorResponse {
        $self = new ApiErrorResponse();
        $for = \Derhub\Shared\Utils\Str::snake(
            \Derhub\Shared\Capabilities\ClassName::for($e::class)
        );
        $errors = [
            [
                'type' => 'exception',
                'field' => $for,
                //TODO: implement message translation
                'message' => $e->getMessage(),
            ],
        ];
        $self->setErrors($errors);

        return $self;
    }


    public static function fromUnAuthorizeRequest(): ApiErrorResponse
    {
        $self = new ApiErrorResponse();
        $self->setStatus(ApiErrorResponse::HTTP_ACCESS_DENIED);
        $errors = [
            [
                'type' => 'authorization',
                'field' => null,
                'message' => 'Forbidden access',
            ],
        ];
        $self->setErrors($errors);

        return $self;
    }
}
