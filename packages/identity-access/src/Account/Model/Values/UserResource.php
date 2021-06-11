<?php

namespace Derhub\IdentityAccess\Account\Model\Values;

use Derhub\Shared\Utils\Assert;
use Derhub\Shared\Values\ValueObject;
use Derhub\IdentityAccess\Account\Shared\KnownResourceTypes;

class UserResource implements ValueObject
{
    private ?UserId $userId;
    private ?string $id;
    private ?string $type;
    private mixed $value;

    public function __construct()
    {
        $this->id = null;
        $this->userId = new UserId();
        $this->type = null;
    }

    public static function with(
        ?UserId $userId,
        ?string $id,
        ?string $type,
        mixed $value
    ): self {
        Assert::inArray($type, KnownResourceTypes::all());

        if ($type === KnownResourceTypes::MULTI) {
            Assert::isArray($value);
        }

        $self = new self();

        $self->value = $value;
        $self->id = $id;
        $self->type = $type;
        $self->userId = $userId;

        return $self;
    }

    public function sameAs(ValueObject $other): bool
    {
        return $other instanceof self
            && $other->id() === $this->id()
            && $other->userId() === $this->userId();
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function id(): ?string
    {
        return $this->id;
    }

    public function isEmpty(): bool
    {
        return $this->userId->isEmpty()
            && empty($this->id)
            && empty($this->type)
            && empty($this->value);
    }
}