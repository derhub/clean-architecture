<?php

namespace Derhub\Integration\TacticianBus\Locator;

use Derhub\Integration\AbstractListenerProvider;

abstract class ContainerLocator extends AbstractListenerProvider implements ContainerLocatorInterface
{
    /**
     * @throws \Derhub\Integration\MissingHandlerException
     */
    public function getHandlerForCommand($commandName): object
    {
        return $this->getListenersForEvent($commandName);
    }

    protected function resolveClass(string $class): mixed
    {
        return $this->container->resolve($class);
    }

    public function getClassName(string $name): ?string
    {
        return $this->nameLookup[$name] ?? null;
    }

    public function getName(string $className): ?string
    {
        return $this->classLookup[$className] ?? null;
    }
}
