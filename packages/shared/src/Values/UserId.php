<?php

namespace Derhub\Shared\Values;

class UserId extends AggregateRootUuid
{
    public function __toString()
    {
        if ($val = $this->toString()) {
            return sprintf('user id %s', $val);
        }

        return 'empty user id';
    }
}
