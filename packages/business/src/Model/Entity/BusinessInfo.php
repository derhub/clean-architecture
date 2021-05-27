<?php

namespace Derhub\Business\Model\Entity;

use Derhub\Business\Model\Values\Country;
use Derhub\Business\Model\Values\Name;
use Derhub\Business\Model\Values\OwnerId;
use Derhub\Shared\Entity\Entity;
use Derhub\Shared\Utils\Assert;
use libphonenumber\CountryCodeToRegionCodeMap;

class BusinessInfo implements Entity
{
    private Name $name;
    private OwnerId $ownerId;
    private Country $country;

    public function __construct()
    {
        $this->name = new Name();
        $this->ownerId = new OwnerId();
        $this->country = new Country();
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

    public function newCountry(Country $country): self
    {
        $self = clone $this;
        $self->country = $country;
        return $self;
    }

    public static function fromArray(array $values): self
    {
        Assert::keyExists($values, 'name');
        Assert::keyExists($values, 'owner_id');

        $self = new self();
        $self->name = Name::fromString($values['name']);
        $self->ownerId = OwnerId::fromString($values['owner_id']);

        return $self;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name()->toString(),
            'owner_id' => $this->ownerId()->toString(),
        ];
    }

    public function sameAs(Entity $other): bool
    {
        return $other instanceof self
            && $other->ownerId() === $this->ownerId();
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function ownerId(): OwnerId
    {
        return $this->ownerId;
    }

    public function country(): Country
    {
        return $this->country;
    }
}