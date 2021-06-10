<?php

namespace App\BuildingBlocks\Actions\Capabilities;

use App\BuildingBlocks\Actions\DispatcherResponse;
use App\BuildingBlocks\Actions\ApiResponseFactory;
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
                return ApiResponseFactory::fromUnAuthorizeRequest();
            }

            $validate = $this->validate($payload);
            if ($validate->fails()) {
                return ApiResponseFactory::fromValidation($validate);
            }

            $response = $this->handle(...$payload);

            return ApiResponseFactory::fromMessageResponse($response);
        } catch (DomainException | ApplicationException $e) {
            return ApiResponseFactory::fromException($e, self::MODULE);
        }
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
