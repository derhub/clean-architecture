<?php

namespace Derhub\IdentityAccess\Account\Model;

use Derhub\Shared\Values\ValueObject;
use Derhub\IdentityAccess\Account\Model\Values\Email;
use Derhub\IdentityAccess\Account\Model\Values\Password;
use Derhub\IdentityAccess\Account\Model\Values\Username;

class Credentials implements ValueObject
{
    private Username $username;
    private Password $password;
    private Email $email;


    public function __construct()
    {
        $this->username = new Username();
        $this->password = new Password();
        $this->email = new Email();
    }

    public static function with(
        Username $username,
        Email $email,
        Password $password
    ): self {
        $self = new self();
        $self->email = $email;
        $self->password = $password;
        $self->username = $username;

        return $self;
    }

    public function sameAs(ValueObject $other): bool
    {
        return $other instanceof self
            && $other->username() === $this->username()
            && $other->username() === $this->username()
            && $other->email() === $this->email();
    }

    public function username(): Username
    {
        return $this->username;
    }

    public function setUsername(Username $username): self
    {
        $self = clone $this;
        $self->username = $username;
        return $self;
    }

    public function password(): Password
    {
        return $this->password;
    }

    public function setPassword(Password $password): self
    {
        $self = clone $this;
        $self->password = $password;
        return $self;
    }

    public function email(): Email
    {
        return $this->email;
    }


    public function setEmail(Email $email): self
    {
        $self = clone $this;
        $self->email = $email;
        return $self;
    }


}