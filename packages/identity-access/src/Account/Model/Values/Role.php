<?php

namespace Derhub\IdentityAccess\Account\Model\Values;

use Derhub\Shared\Values\ValueObjectStr;

class Role implements ValueObjectStr
{
    use BasicStringValue;

    public static function fromString(string $value): static
    {
        $self = new self();
        $self->value = $value;
        return $self;
    }

    public function __toString()
    {
        if ($this->isEmpty()) {
            return 'empty role';
        }

        return 'user role '.$this->toString();
    }
}