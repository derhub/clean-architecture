<?php

namespace Derhub\Integration\TacticianBus\Handlers;

use Derhub\Shared\Message\ListenerProviderInterface;
use League\Tactician\Exception\CanNotInvokeHandlerException;
use League\Tactician\Handler\MethodNameInflector\MethodNameInflector;
use League\Tactician\Middleware;

abstract class AbstractMessageHandler implements Middleware
{
    protected bool $allowMultipleHandlers;

    public function __construct(
        protected ListenerProviderInterface $handlerLocator,
        protected MethodNameInflector $methodNameInflector
    ) {
        $this->allowMultipleHandlers = false;
    }

    protected function handleMessage(object $message): mixed
    {
        [
            'handler' => $handler,
        ] = $this->requirements($message);

        $methodName =
            $this->methodNameInflector->inflect($message, $handler);

        return $this->callHandler($message, $handler, $methodName);
    }

    protected function callHandler($message, $handler, $methodName): mixed
    {
        if (is_iterable($handler)) {
            foreach ($handler as $handle) {
                $this->callHandler($message, $handle, $methodName);
            }

            return null;
        }

        if (! method_exists($handler, $methodName)) {
            throw CanNotInvokeHandlerException::forCommand(
                $message,
                "Method '{$methodName}' does not exist on handler"
            );
        }

        return $handler->{$methodName}($message);
    }


    protected function requirements(object $message): array
    {
        $handler = $this->handlerLocator->getListenersForEvent($message::class);

        return [
            'name' => $message::class,
//            'alias' => $this->handlerLocator->getName($message::class),
            'handler' => $handler,
        ];
    }
}
