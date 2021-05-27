<?php

namespace Derhub\Integration;

use Derhub\Shared\Message\Message;

class NameOnlyMessage implements Message
{
    public function version(): int
    {
        return 1;
    }
}