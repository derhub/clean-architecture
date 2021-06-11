<?php

namespace Derhub\IdentityAccess\Account\Model\Values;

use Derhub\Shared\Utils\Assert;
use Derhub\Shared\Values\ValueObjectStr;

class Username implements ValueObjectStr
{
    use BasicStringValue;

    public static function fromString(string $value): self
    {
        Assert::betweenLength($value, 5, 100);
        Assert::alnum($value, 'Invalid username');
        $self = new self();
        $self->value = $value;
        return $self;
    }

    public function __toString()
    {
        if ($this->isEmpty()) {
            return 'empty username';
        }

        return 'username [secrete]';
    }
}