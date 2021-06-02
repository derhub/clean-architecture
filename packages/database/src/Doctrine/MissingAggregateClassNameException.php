<?php

namespace Derhub\Shared\Database\Doctrine;

use Derhub\Shared\Exceptions\InfrastructureException;

class MissingAggregateClassNameException extends \Exception implements InfrastructureException
{
    public static function notProvided(): self
    {
        return new self('Aggregate class name not provided');
    }
}
