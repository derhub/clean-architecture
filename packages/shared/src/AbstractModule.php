<?php

namespace Derhub\Shared;

use Derhub\Shared\Capabilities\ModuleCapabilities;

abstract class AbstractModule implements ModuleInterface
{
    use ModuleCapabilities;
}
