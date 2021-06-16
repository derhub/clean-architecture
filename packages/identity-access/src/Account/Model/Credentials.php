<?php

namespace Derhub\IdentityAccess\Account\Model;

use Derhub\Shared\Values\ValueObject;
use Derhub\IdentityAccess\Account\Model\Values\Email;
use Derhub\IdentityAccess\Account\Model\Values\HashedPassword;
use Derhub\IdentityAccess\Account\Model\Values\Username;

class Credentials implements ValueObject
{
    private Username $username;
    private HashedPassword $password;
    private Email $email;
    private ?string $rememberToken;
    private ?string $twoFactorSecrete;
    private ?string $twoFactorRecoveryCodes;

    public function __construct()
    {
        $this->username = new Username();
        $this->password = new HashedPassword();
        $this->email = new Email();
        $this->rememberToken = null;
        $this->twoFactorSecrete = null;
        $this->twoFactorRecoveryCodes = null;
    }

    public static function with(
        Username $username,
        Email $email,
        HashedPassword $password
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

    public function password(): HashedPassword
    {
        return $this->password;
    }

    public function email(): Email
    {
        return $this->email;
    }


    public function rememberToken(): ?string
    {
        return $this->rememberToken;
    }

    public function twoFactorSecrete(): ?string
    {
        return $this->twoFactorSecrete;
    }

    public function twoFactorRecoveryCodes(): ?string
    {
        return $this->twoFactorRecoveryCodes;
    }

    public function setUsername(Username $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function setPassword(HashedPassword $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function setEmail(Email $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function setRememberToken(?string $rememberToken): self
    {
        $this->rememberToken = $rememberToken;
        return $this;
    }

    public function setTwoFactorSecrete(?string $twoFactorSecrete): self
    {
        $this->twoFactorSecrete = $twoFactorSecrete;
        return $this;
    }

    public function setTwoFactorRecoveryCodes(
        ?string $twoFactorRecoveryCodes
    ): self {
        $this->twoFactorRecoveryCodes = $twoFactorRecoveryCodes;
        return $this;
    }


}