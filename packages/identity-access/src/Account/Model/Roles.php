<?php

namespace Derhub\IdentityAccess\Account\Model;

use Derhub\Shared\Values\ValueObject;
use Derhub\IdentityAccess\Account\Model\Values\Role;

class Roles implements ValueObject
{
    /**
     * @var Role[]
     */
    private array $values;

    public function __construct()
    {
        $this->values = [];
    }

    public function sameAs(ValueObject $other): bool
    {
        return $other instanceof self;
    }

    public function remove(Role ...$roles): self
    {
        $self = clone $this;
        foreach ($roles as $role) {
            if (isset($values[$role->toString()])) {
                unset($self->values[$role->toString()]);
            }
        }

        return $self;
    }

    public function add(Role ...$roles): self
    {
        $self = clone $this;
        $values = $this->values;

        foreach ($roles as $role) {
            if (! isset($values[$role->toString()])) {
                $self->values[$role->toString()] = $role;
            }
        }

        return $self;
    }

    public function all(): array
    {
        return $this->values;
    }

    public function toArray(): array
    {
        $result = [];
        foreach ($this->values as $role) {
            $str = $role->toString();
            $result[$str] = $str;
        }
        return $result;
    }
}