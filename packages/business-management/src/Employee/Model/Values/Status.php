<?php

namespace Derhub\BusinessManagement\Employee\Model\Values;

use Derhub\Shared\Values\UuidValueObject;
use Derhub\Shared\Values\ValueObjectStr;

class Status implements ValueObjectStr
{
    use UuidValueObject {
        UuidValueObject::__construct as private __parentInit;
    }

    private ?string $name;

    public function __construct()
    {
        $this->__parentInit();
        $this->name = null;
    }

    public static function with(string $id, string $name): self
    {
        $self = self::fromString($id);
        $self->name = $name;
        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self->name = $name;
        return $self;
    }

    public function __toString()
    {
        if ($this->isEmpty()) {
            return 'unknown employee status';
        }

        return 'employee status id: '.$this->toString();
    }

    public function title(): ?string
    {
        return $this->title;
    }
}