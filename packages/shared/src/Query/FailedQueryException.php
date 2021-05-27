<?php

namespace Derhub\Shared\Query;

use Derhub\Shared\Exceptions\InfrastructureException;

class FailedQueryException extends \Exception implements InfrastructureException
{
    public static function fromThrowable(\Throwable $e): self
    {
        return new self($e->getMessage(), $e->getCode(), $e);
    }
}