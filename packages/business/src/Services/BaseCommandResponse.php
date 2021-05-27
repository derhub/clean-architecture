<?php

namespace Derhub\Business\Services;

use Derhub\Business\Module;
use Derhub\Shared\Message\Command\AbstractCommandResponse;

abstract class BaseCommandResponse extends AbstractCommandResponse
{
    public function aggregate(): string
    {
        return Module::ID;
    }
}