<?php

namespace EB\Template\Model;

use EB\Shared\Entity\Entity;
use EB\Shared\Utils\Assert;
use EB\Shared\ValueObject\Email;

class SampleEntity implements Entity
{
    private Email $email;
    private string $name;

    public function __construct()
    {
        $this->email = new Email();
        $this->name = '';
    }

    public function newEmail(Email $mail): self
    {
        $self = clone $this;
        $self->email = $mail;
        return $self;
    }

    public function newName(string $name): self
    {
        $self = clone $this;
        $self->name = $name;
        return $self;
    }

    public static function fromArray(array $values): self
    {
        Assert::keyExists($values, 'email');
        Assert::keyExists($values, 'name');

        $self = new self();
        $self->email = Email::fromString($values['email']);
        $self->name = $values['name'];

        return $self;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name(),
            'email' => $this->email->toString(),
        ];
    }

    public function sameIdentity(Entity $other): bool
    {
        return $other instanceof self
            && $other->email() === $this->email();
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): Email
    {
        return $this->email;
    }
}