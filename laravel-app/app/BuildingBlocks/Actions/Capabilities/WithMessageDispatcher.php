<?php

namespace App\BuildingBlocks\Actions\Capabilities;

use App\BuildingBlocks\Actions\ApiResponse;
use App\BuildingBlocks\Actions\ApiResponseFactory;
use Derhub\Shared\Exceptions\LayeredException;
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
    abstract public static function withMessageClass(): string;

    public function dispatch(): ApiResponse
    {
        try {
            $payload = $this->getPayload();

            $isAuthorize = $this->authorize($payload);
            if (! $isAuthorize) {
                return ApiResponseFactory::fromUnAuthorizeRequest();
            }

            $validate = $this->validate($payload);
            if ($validate->fails()) {
                return ApiResponseFactory::fromValidation($validate);
            }

            $response = $this->handle(...$payload);

            return ApiResponseFactory::fromMessageResponse($response);
        } catch (LayeredException $e) {
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

    /**
     * @throws \Exception
     */
    public function handle(...$args): CommandResponse|QueryResponse
    {
        $class = static::withMessageClass();
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
