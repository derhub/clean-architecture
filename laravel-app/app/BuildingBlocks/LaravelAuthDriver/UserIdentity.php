<?php

namespace App\BuildingBlocks\LaravelAuthDriver;

use Derhub\IdentityAccess\Account\Services\UserAccount;
use Illuminate\Auth\GenericUser;

/**
 * TODO: implement remember token
 */
class UserIdentity extends GenericUser
{
    private ?string $rememberToken = null;

    public function __construct(private UserAccount $account)
    {
        parent::__construct($account->toArray());
    }

    public function getUserAccount(): UserAccount
    {
        return $this->account;
    }

    public function getRememberToken(): ?string
    {
        return $this->rememberToken;
    }

    public function setRememberToken($value): void
    {
        $this->rememberToken = $value;
    }
}