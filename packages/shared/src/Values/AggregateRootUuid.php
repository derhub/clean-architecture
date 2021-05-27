<?php

namespace Derhub\Shared\Values;

use Derhub\Shared\Model\AggregateRootId;
use Stringable;

/**
 * @psalm-consistent-constructor
 */
abstract class AggregateRootUuid implements AggregateRootId
{
    use UuidValueObject;
}
