<?php

namespace Derhub\Laravel\IdentityAccess\AuthProvider;

use Derhub\IdentityAccess\Account\Model\ComparePassword;
use Derhub\IdentityAccess\Account\Services\Credentials\ChangeRememberToken;
use Derhub\IdentityAccess\Account\Services\Query\GetByEmail;
use Derhub\IdentityAccess\Account\Services\Query\GetByUserId;
use Derhub\IdentityAccess\Account\Services\Query\GetByUsername;
use Derhub\IdentityAccess\Account\Shared\UserStatus;
use Derhub\Shared\Message\Command\CommandBus;
use Derhub\Shared\Message\Query\QueryBus;
use Derhub\Shared\Message\Query\QueryResponse;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

class IdentityAccessAuthProvider implements UserProvider
{
    public const NAME = 'identity_access_auth_driver';

    public function __construct(
        private QueryBus $queryBus,
        private CommandBus $cmdBus,
        private ComparePassword $comparePassword
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
        $user = $this->getById($identifier);
        return $user && $user->getRememberToken()
        && hash_equals($user->getRememberToken(), $token)
            ? $user : null;
    }

    public function updateRememberToken(Authenticatable $user, $token): void
    {
        $this->cmdBus->dispatch(
            new ChangeRememberToken($user->getAuthIdentifier(), $token)
        );

        $user->setRememberToken($token);
    }

    public function retrieveByCredentials(array $credentials): ?UserIdentity
    {
        $email = $credentials['email'] ?? null;
        $username = $credentials['username'] ?? null;

        if (! $email && ! $username) {
            return null;
        }

        if ($email) {
            $query = $this->queryBus->dispatch(
                new GetByEmail($email)
            );
        } else {
            $query = $this->queryBus->dispatch(
                new GetByUsername($email)
            );
        }

        return $this->mapQueryResult($query);
    }

    public function validateCredentials(
        UserIdentity|Authenticatable $user,
        array $credentials
    ): bool {
        $account = $user->getUserAccount();

        return $this->comparePassword->compare(
            $credentials['password'],
            $account->password()
        );
    }
}