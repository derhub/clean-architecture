<?php

namespace Derhub\Shared\MessageOutbox\Exceptions;

use Derhub\Shared\Exceptions\InfrastructureException;

interface FailedToProcessMessage extends InfrastructureException
{
}
