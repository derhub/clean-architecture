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
     * @return FieldManager
     */
    public static function fields(): FieldManager;

    public static function getComputedFields(): FieldManager;

    /**
     * Register routes
     */
    public static function routes(): void;

    /**
     * Return message class
     * @return class-string<Query|Command>
     */
    public static function getCommandClass(): string;

    public function authorize(): bool;

    /**
     * Handle validation and user request
     * @return \App\BuildingBlocks\Actions\DispatcherResponse
     */
    public function dispatch(): DispatcherResponse;

    /**
     * Array of sanitize field value found in segment, query and post body
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

    public static function getActionId(): string;

    public static function getModuleId(): string;

    public static function getCommandType(): string;

    public static function getRoutePath(): string;

    public static function getRouteName(): string;

    public static function getRouteMethod(): string;
}
