<?php

namespace Derhub\Template\Model\Values;

use Derhub\Shared\Model\AggregateRootId;
use Derhub\Shared\Values\UuidValueObject;

final class TemplateId implements AggregateRootId
{
    use UuidValueObject;

    public function __toString(): string
    {
        if ($value = $this->toString()) {
            return sprintf('template id %s', $value);
        }

        return 'empty template id';
    }
}
