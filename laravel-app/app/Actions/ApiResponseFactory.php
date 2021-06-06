<?php

namespace App\Actions;

use Derhub\Shared\Message\Command\CommandResponse;
use Derhub\Shared\Message\Query\QueryResponse;
use Illuminate\Validation\Validator;

class ApiResponseFactory
{
    public static function create(
        null | CommandResponse | QueryResponse $response
    ): ApiMessageResponse {
        return new ApiMessageResponse($response);
    }

    public static function fromCommand(
        CommandResponse $response
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
    ): ApiValidateErrorResponse {
        $self = new ApiValidateErrorResponse();
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
}
