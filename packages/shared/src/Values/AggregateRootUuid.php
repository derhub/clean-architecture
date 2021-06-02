<?php

namespace Derhub\Shared\Values;

use Derhub\Shared\Model\AggregateRootId;

/**
 * @psalm-consistent-constructor
 */
abstract class AggregateRootUuid implements AggregateRootId
{
    use UuidValueObject;
}
