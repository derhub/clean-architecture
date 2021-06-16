<?php

namespace Derhub\Shared\Database\Exceptions;

use Derhub\Shared\Model\Exceptions\AggregateNotFoundException;

class AggregateNotFound extends \Exception implements AggregateNotFoundException
{
    public static function fromId(mixed $id): self
    {
        return new self(
            sprintf('%s aggregate not found', $id),
        );
    }

    public static function fromCriteria(array $criteria): self
    {
        return new self('unable to find aggregate with the given criteria');
    }
}
