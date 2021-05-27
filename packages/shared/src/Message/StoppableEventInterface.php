<?php

namespace Derhub\Shared\Message;

interface StoppableEventInterface
{
    public function isPropagationStopped(): bool;
}
