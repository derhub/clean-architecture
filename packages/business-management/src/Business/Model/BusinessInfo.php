<?php

namespace Derhub\BusinessManagement\Business\Model;

use Derhub\BusinessManagement\Business\Model\Values\Country;
use Derhub\BusinessManagement\Business\Model\Values\Name;
use Derhub\BusinessManagement\Business\Model\Values\OwnerId;
use Derhub\BusinessManagement\Business\Model\Values\Status;
use Derhub\Shared\Model\Entity;
use Derhub\Shared\Utils\Assert;

class BusinessInfo implements Entity
{
    private Country $country;
    private Name $name;
    private OwnerId $ownerId;
    private Status $status;

    public static function fromArray(array $values): self
    {
        Assert::keyExists($values, 'name');
        Assert::keyExists($values, 'owner_id');

        $self = new self();
        $self->name = Name::fromString($values['name']);
        $self->ownerId = OwnerId::fromString($values['owner_id']);

        return $self;
    }

    public function __construct()
    {
        $this->name = new Name();
        $this->ownerId = new OwnerId();
        $this->country = new Country();
        $this->status = Status::enable();
    }

    public function country(): Country
    {
        return $this->country;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function newCountry(Country $country): self
    {
        $self = clone $this;
        $self->country = $country;

        return $self;
    }

    public function newName(Name $name): self
    {
        $self = clone $this;
        $self->name = $name;

        return $self;
    }

    public function newOwner(OwnerId $ownerId): self
    {
        $self = clone $this;
        $self->ownerId = $ownerId;

        return $self;
    }

    public function newStatus(Status $status): self
    {
        $self = clone $this;
        $self->status = $status;

        return $self;
    }

    public function ownerId(): OwnerId
    {
        return $this->ownerId;
    }


    public function sameAs(Entity $other): bool
    {
        return $other instanceof self
            && $other->ownerId()->toString() === $this->ownerId()->toString()
            && $other->name()->toString() === $this->name()->toString()
            && $other->country()->toString() === $this->country()->toString();
    }

    public function status(): Status
    {
        return $this->status;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name()->toString(),
            'owner_id' => $this->ownerId()->toString(),
            'country' => $this->country()->toString(),
            'status' => $this->status()->toString(),
        ];
    }
}
