<?php

namespace Derhub\Shared\Message\Command;

use Derhub\Shared\Message\DispatcherInterface;

interface CommandBus extends DispatcherInterface
{
    /**
     * @param \Derhub\Shared\Message\Command\Command ...$message
     * @return \Derhub\Shared\Message\Command\CommandResponse|array|null
     */
    public function dispatch(Command ...$message): null|CommandResponse|array;
}
