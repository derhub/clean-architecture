<?php

namespace Derhub\Integration\TacticianBus\Locator;

use Derhub\Shared\Message\ListenerProviderInterface;
use League\Tactician\Handler\Locator\HandlerLocator;

interface ContainerLocatorInterface extends HandlerLocator, ListenerProviderInterface
{
}
