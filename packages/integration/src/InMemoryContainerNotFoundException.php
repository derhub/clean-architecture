<?php

namespace Derhub\Integration;

use Psr\Container\NotFoundExceptionInterface;

class InMemoryContainerNotFoundException extends \Exception implements NotFoundExceptionInterface
{

}