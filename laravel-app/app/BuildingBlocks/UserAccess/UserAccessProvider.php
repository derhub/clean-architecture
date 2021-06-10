<?php

namespace App\BuildingBlocks\UserAccess;

use Illuminate\Contracts\Auth\UserProvider;

class UserAccessProvider implements UserProvider
{
    public function retrieveById($identifier)
    {
        // TODO: Implement retrieveById() method.
    }

    public function retrieveByToken($identifier, $token)
    {
        // TODO: Implement retrieveByToken() method.
    }

    public function updateRememberToken(
        \Illuminate\Contracts\Auth\Authenticatable $user,
        $token
    ) {
        // TODO: Implement updateRememberToken() method.
    }

    public function retrieveByCredentials(array $credentials)
    {
        // TODO: Implement retrieveByCredentials() method.
    }

    public function validateCredentials(
        \Illuminate\Contracts\Auth\Authenticatable $user,
        array $credentials
    ) {
        // TODO: Implement validateCredentials() method.
    }
}
