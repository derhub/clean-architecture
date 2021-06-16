<?php

namespace Derhub\IdentityAccess\Account\Services;

use Derhub\Shared\Query\QueryItem;

class UserAccount implements QueryItem
{
    public function __construct(
        private string $id,
        private int $status,
        private ?string $username,
        private string $email,
        private ?string $password,
        private ?string $rememberToken,
        private ?string $twoFactorSecrete,
        private ?string $twoFactorRecoverCodes,
        private ?string $createdAt,
        private ?string $updatedAt,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id(),
            'username' => $this->username(),
            'email' => $this->email(),
            'status' => $this->status(),
            'password' => '[secrete]',
            'remember_token' => $this->rememberToken(),
            'two_factor_secrete' => $this->twoFactorSecrete(),
            'two_factor_recovery_codes' => $this->twoFactorRecoverCodes(),
            'created_at' => $this->createdAt(),
            'updated_at' => $this->updatedAt(),
        ];
    }


    public function id(): string
    {
        return $this->id;
    }

    public function username(): ?string
    {
        return $this->username;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function status(): int
    {
        return $this->status;
    }

    public function createdAt(): ?string
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function rememberToken(): ?string
    {
        return $this->rememberToken;
    }

    public function twoFactorSecrete(): ?string
    {
        return $this->twoFactorSecrete;
    }

    public function twoFactorRecoverCodes(): ?string
    {
        return $this->twoFactorRecoverCodes;
    }


    public function __debugInfo(): ?array
    {
        $properties = get_object_vars($this);
        $properties['password'] = '[secrete]';
        return $properties;
    }
}