<?php

namespace EB\Template\Services;

use EB\Template\Module;

class CommonCommandResponse extends \EB\Shared\Message\Command\AbstractCommandResponse
{
    public function aggregate(): string
    {
        return Module::ID;
    }
}