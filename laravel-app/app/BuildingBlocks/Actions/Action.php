<?php

namespace App\BuildingBlocks\Actions;

use Derhub\Shared\Message\Command\Command;
use Derhub\Shared\Message\Command\CommandResponse;
use Derhub\Shared\Message\Query\Query;
use Derhub\Shared\Message\Query\QueryResponse;

interface Action
{
    /**
     * Return field configuration
     * example:
     * [
     *  'fieldName' => [
     *      'required' => boolean,
     *      'default' => mixed,
     *      'rules' => array,
     *  ]
     * ]
     * ]
     * @return array
     */
    public static function fields(): array;

    /**
     * Register routes
     */
    public static function routes(): void;

    /**
     * Return message class
     * @return class-string<Query|Command>
     */
    public static function withMessageClass(): string;

    public function authorize(array $payload): bool;

    /**
     * Handle validation and user request
     * @return \App\BuildingBlocks\Actions\ApiResponse
     */
    public function dispatch(): ApiResponse;

    /**
     * List of data found in post body, query and url segment
     * filter by fields key
     * @return array
     */
    public function getPayload(): array;

    /**
     * Dispatch message
     *
     * @param mixed ...$args The message constructor argument
     * @return \Derhub\Shared\Message\Command\CommandResponse|\Derhub\Shared\Message\Query\QueryResponse
     * @throws
     */
    public function handle(mixed ...$args): CommandResponse|QueryResponse;

    /**
     * Return true of pass and Response when fails
     * @param array $payload
     */
    public function validate(array $payload): \Illuminate\Validation\Validator;

    /**
     * Return array that will later use in validation rules
     * @param array $payload
     * @return array
     */
    public function validationRules(array $payload): array;
}
