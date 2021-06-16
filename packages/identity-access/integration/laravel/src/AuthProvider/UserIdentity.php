<?php

namespace Derhub\Laravel\IdentityAccess\AuthProvider;

use Derhub\IdentityAccess\Account\Services\UserAccount;
use Illuminate\Auth\GenericUser;

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
        return $this->attributes['remember_token'];
    }

    public function setRememberToken($value): void
    {
        $this->attributes['remember_token'] = $value;
    }
}