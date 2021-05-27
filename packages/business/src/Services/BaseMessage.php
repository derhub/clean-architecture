<?php

namespace Derhub\Business\Services;

use Derhub\Shared\Message\Message;

abstract class BaseMessage implements Message
{
    private int $version = 1;

    public function version(): int
    {
        return $this->version;
    }
}