<?php

namespace Derhub\Shared\Database\Exceptions;

use Derhub\Shared\Model\AggregateRoot;
use Derhub\Shared\Model\Exceptions\FailedToSaveAggregateException;

class FailedToSaveAggregate extends \Exception
    implements FailedToSaveAggregateException
{
    public static function fromAggregateWithException(
        AggregateRoot $aggregateRoot,
        \Throwable $e
    ): self {
        return new self(
            sprintf('Unable to save %s', $aggregateRoot::class),
            0,
            $e
        );
    }
}