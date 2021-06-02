<?php

namespace Derhub\Shared\Message\Command;

interface CommandResponse extends \Derhub\Shared\Message\MessageResponse
{
    public function aggregateRootId(): mixed;
}
