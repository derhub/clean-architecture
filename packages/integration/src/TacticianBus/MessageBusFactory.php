<?php

namespace Derhub\Integration\TacticianBus;

use Derhub\Integration\TacticianBus\Handlers\MultipleMessageHandler;
use Derhub\Shared\Message\Command\CommandBus;
use Derhub\Shared\Message\Event\EventListenerProvider;
use Derhub\Shared\Message\ListenerProviderInterface;
use Derhub\Shared\Message\Query\QueryBus;
use Derhub\Shared\Message\Query\QueryListenerProvider;
use League\Tactician\Handler\MethodNameInflector\InvokeInflector;
use League\Tactician\Plugins\LockingMiddleware;

class MessageBusFactory
{
    public static function createCommandBus(
        ListenerProviderInterface $locator,
        array $middlewares = [],
    ): CommandBus {
        return new TacticianCommandBus(
            [
                new LockingMiddleware(),
                ...$middlewares,
                self::createMiddlewareHandler($locator),
            ]
        );
    }

    public static function createQueryBus(
        QueryListenerProvider $locator,
        array $middlewares = [],
    ): QueryBus {
        return new TacticianQueryBus(
            [
                ...$middlewares,
                self::createMiddlewareHandler($locator),
            ]
        );
    }

    public static function createEventBus(
        EventListenerProvider $locator,
        array $middlewares = [],
    ): TacticianEventBus {
        return new TacticianEventBus(
            [
                ...$middlewares,
                self::createMiddlewareHandler($locator),
            ]
        );
    }

    private static function createMiddlewareHandler(
        ListenerProviderInterface $locator
    ): MultipleMessageHandler {
        $inflector = new InvokeInflector();

        return new MultipleMessageHandler(
            $locator,
            $inflector,
        );
    }
}
