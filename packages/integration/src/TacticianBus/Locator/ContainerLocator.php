<?php

namespace Derhub\Integration\TacticianBus\Locator;

use Derhub\Integration\AbstractListenerProvider;

abstract class ContainerLocator extends AbstractListenerProvider implements ContainerLocatorInterface
{
    public function getClassName(string $name): ?string
    {
        return $this->nameLookup[$name] ?? null;
    }
    /**
     * @throws \Derhub\Integration\MissingHandlerException
     */
    public function getHandlerForCommand($commandName): object
    {
        return $this->getListenersForEvent($commandName);
    }

    public function getName(string $className): ?string
    {
        return $this->classLookup[$className] ?? null;
    }

    protected function resolveClass(string $class): mixed
    {
        return $this->container->resolve($class);
    }
}
