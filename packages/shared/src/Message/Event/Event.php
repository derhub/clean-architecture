<?php

namespace Derhub\Shared\Message\Event;

interface Event extends \Derhub\Shared\Message\Message
{
    public function aggregateRootId(): ?string;
}
