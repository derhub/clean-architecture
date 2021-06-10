<?php

namespace App\BuildingBlocks\Actions;

use Derhub\Shared\Message\Command\CommandResponse;
use Derhub\Shared\Message\Query\QueryResponse;
use Derhub\Shared\Utils\ClassName;
use Derhub\Shared\Utils\Str;
use Illuminate\Validation\Validator;
use Throwable;

class ApiResponseFactory
{
    public static function create(
        null|CommandResponse|QueryResponse $response
    ): DispatcherSuccessResponse {
        return new DispatcherSuccessResponse($response);
    }

    public static function fromCommand(
        CommandResponse $response
    ): DispatcherSuccessResponse {
        return new DispatcherSuccessResponse($response);
    }

    public static function fromMessageResponse(
        CommandResponse|QueryResponse $response
    ): DispatcherSuccessResponse {
        return new DispatcherSuccessResponse($response);
    }

    public static function fromQuery(
        QueryResponse $response,
    ): DispatcherSuccessResponse {
        return new DispatcherSuccessResponse($response);
    }

    public static function fromValidation(
        Validator $validator
    ): DispatcherErrorResponse {
        $self = new DispatcherErrorResponse();
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
        Throwable $e,
        string $moduleId = null
    ): DispatcherErrorResponse {
        $self = new DispatcherErrorResponse();
        $for = Str::snake(
            ClassName::for($e::class)
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


    public static function fromUnAuthorizeRequest(): DispatcherErrorResponse
    {
        $self = new DispatcherErrorResponse();
        $self->setStatus(DispatcherErrorResponse::HTTP_ACCESS_DENIED);
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
