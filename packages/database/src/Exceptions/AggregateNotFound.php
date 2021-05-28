<?php

namespace Derhub\Shared\Database\Exceptions;

use Derhub\Shared\Model\AggregateRootId;
use Derhub\Shared\Model\Exceptions\AggregateNotFoundException;

class AggregateNotFound extends \Exception implements AggregateNotFoundException
{
    public static function fromId(AggregateRootId $id): self
    {
        return new self(
            sprintf('%s aggregate not found', (string)$id),
        );
    }
}