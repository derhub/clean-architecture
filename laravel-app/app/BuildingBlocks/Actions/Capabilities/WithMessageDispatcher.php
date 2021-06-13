<?php

namespace App\BuildingBlocks\Actions\Capabilities;

use App\BuildingBlocks\Actions\DispatcherResponse;
use App\BuildingBlocks\Actions\DispatcherResponseFactory;
use Derhub\Shared\Exceptions\ApplicationException;
use Derhub\Shared\Exceptions\DomainException;
use Derhub\Shared\Message\Command\Command;
use Derhub\Shared\Message\Command\CommandBus;
use Derhub\Shared\Message\Command\CommandResponse;
use Derhub\Shared\Message\Query\Query;
use Derhub\Shared\Message\Query\QueryBus;
use Derhub\Shared\Message\Query\QueryResponse;

trait WithMessageDispatcher
{
    protected ?CommandBus $commandBus = null;

    protected ?QueryBus $queryBus = null;

    /**
     * Return command or query class
     *
     * @return class-string<Query|Command>
     */
    abstract public static function getCommandClass(): string;

    public function dispatch(): DispatcherResponse
    {
        try {
            $payload = $this->getPayload();

            if (! $this->authorize()) {
                return DispatcherResponseFactory::fromUnAuthorizeRequest();
            }

            $validate = $this->validate($payload);
            if ($validate->fails()) {
                return DispatcherResponseFactory::fromValidation($validate);
            }

            $filteredPayload = $this->sanitizePayload($payload);
            $response = $this->handle(...$filteredPayload);

            return DispatcherResponseFactory::fromMessageResponse($response);
        } catch (DomainException | ApplicationException $e) {
            return DispatcherResponseFactory::fromException($e, self::MODULE);
        }
    }

    private function sanitizePayload(array $payload): array
    {
        $fields = static::getComputedFields();
        $results = [];
        foreach ($payload as $key => $value) {
            if (! isset($fields[$key])) {
                continue;
            }

            /** @var \App\BuildingBlocks\Actions\Fields\BaseField $field */
            $field = $fields[$key];
            $results[$key] = $field->applyPayloadModifications($value);
        }

        return $results;
    }

    public function getCommandBus(): CommandBus
    {
        return $this->commandBus ??= app()->get(CommandBus::class);
    }

    public function getQueryBus(): QueryBus
    {
        return $this->queryBus ??= app()->get(QueryBus::class);
    }

    public function handle(...$args): CommandResponse|QueryResponse
    {
        $class = static::getCommandClass();
        $message = new $class(...$args);
        if ($message instanceof Query) {
            return $this->getQueryBus()->dispatch($message);
        }

        if ($message instanceof Command) {
            return $this->getCommandBus()->dispatch($message);
        }

        throw new \Exception(
            'Unable to dispatch because of unrecognized command. Query and Command is only supported'
        );
    }

    public function setCommandBus(CommandBus $commandBus): void
    {
        $this->commandBus = $commandBus;
    }

    public function setQueryBus(QueryBus $queryBus): void
    {
        $this->queryBus = $queryBus;
    }
}
