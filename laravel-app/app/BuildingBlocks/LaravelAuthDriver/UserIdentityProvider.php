<?php

namespace App\BuildingBlocks\LaravelAuthDriver;

use Arr;
use Derhub\IdentityAccess\Account\Services\Query\GetByCredentials;
use Derhub\IdentityAccess\Account\Services\Query\GetByUserId;
use Derhub\IdentityAccess\Account\Shared\UserStatusTypes;
use Derhub\Shared\Message\Query\QueryBus;
use Derhub\Shared\Message\Query\QueryResponse;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class UserIdentityProvider implements UserProvider
{
    public const NAME = 'identity_access_module_driver';

    public function __construct(
        private QueryBus $queryBus,
        private HasherContract $hasher,
    ) {
    }

    private function mapQueryResult(QueryResponse $response): ?UserIdentity
    {
        if (! $response->isSuccess()) {
            return null;
        }

        $result = $response->firstResult();

        if (! $result) {
            return null;
        }

        $notActive = $result->status() !== UserStatusTypes::ACTIVATED;
        if ($notActive) {
            return null;
        }

        return new UserIdentity($result);
    }

    private function getById($id): ?UserIdentity
    {
        $query = $this->queryBus->dispatch(
            new GetByUserId($id)
        );

        return $this->mapQueryResult($query);
    }

    public function retrieveById($identifier): ?UserIdentity
    {
        return $this->getById($identifier);
    }

    public function retrieveByToken($identifier, $token): ?UserIdentity
    {
        // TODO: verify remember token
        return $this->getById($identifier);
    }

    public function updateRememberToken(Authenticatable $user, $token): void
    {
        // TODO: Implement updateRememberToken() method.
        $user->setRememberToken($token);
    }

    public function retrieveByCredentials(array $credentials): ?UserIdentity
    {
        \debugbar()->info($credentials, 'retrieveByToken');
        $emailOrUsername = Arr::get($credentials, 'email')
            ?? Arr::get($credentials, 'username');

        $query = $this->queryBus->dispatch(
            new GetByCredentials($emailOrUsername)
        );

        return $this->mapQueryResult($query);
    }

    public function validateCredentials(
        UserIdentity|Authenticatable $user,
        array $credentials
    ): bool {
        $account = $user->getUserAccount();

        if ($account->status() !== UserStatusTypes::ACTIVATED) {
            return false;
        }

        return $this->hasher->check(
            $credentials['password'],
            $account->password()
        );
    }
}
