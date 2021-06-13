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
        private ?string $createdAt,
        private ?string $updatedAt,
    ) {
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

    public function toArray(): array
    {
        return [
            'id' => $this->id(),
            'username' => $this->username(),
            'email' => $this->email(),
            'status' => $this->status(),
            'password' => '[secrete]',
            'created_at' => $this->createdAt(),
            'updated_at' => $this->updatedAt(),
        ];
    }
}