<?php

namespace Derhub\Integration\TacticianBus\Locator;

use Derhub\Shared\Container\ContainerInterface;
use Derhub\Shared\Message\Query\QueryListenerProvider;
use Derhub\Shared\Utils\Assert;
use League\Tactician\Exception\MissingHandlerException;

class QueryLocator extends ContainerLocator implements QueryListenerProvider
{

    /**
     * @param string $name
     * @param string $message
     * @param string $handler
     */
    public function addHandler(
        string $name,
        string $message,
        mixed $handler = null,
    ): void {
        if ($handler) {
            Assert::string($handler);
        }

        $this->nameLookup[$name] = $message;
        $this->classLookup[$message] = $name;
        $this->handlers[$message] = $handler;
    }

    public function addHandlerByName(string $name, mixed $handler): void
    {
        if (! $this->hasName($name)) {
            throw new \Exception('Unable to event with name '.$name);
        }
        Assert::string($handler);

        $className = $this->getClassName($name);

        $this->handlers[$className] = $handler;
    }
}
