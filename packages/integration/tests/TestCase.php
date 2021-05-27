<?php

namespace Tests\Integration;

use Derhub\Integration\InMemoryContainer;
use Derhub\Integration\TacticianBus\Locator\CmdLocator;
use Derhub\Integration\TacticianBus\Locator\QueryLocator;
use Derhub\Integration\TacticianBus\MessageBusFactory;
use Derhub\Shared\Container\ContainerInterface;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected ContainerInterface $container;

    protected function setUp(): void
    {
        parent::setUp();

        $this->container = new InMemoryContainer();
    }


    protected function createQueryBus(): array
    {
        $locator = new QueryLocator($this->container);
        return [
            'bus' => MessageBusFactory::createQueryBus($locator),
            'listener' => $locator,
        ];
    }

    protected function createCommandBus(): array
    {
        $locator = new CmdLocator($this->container);
        return [
            'bus' => MessageBusFactory::createCommandBus($locator),
            'listener' => $locator,
        ];
    }

    protected function createEventBus(): array
    {
        $locator = new CmdLocator($this->container);
        return [
            'bus' => MessageBusFactory::createCommandBus($locator),
            'listener' => $locator,
        ];
    }
}