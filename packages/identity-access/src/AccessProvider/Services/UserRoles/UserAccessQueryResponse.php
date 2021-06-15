<?php

namespace Derhub\IdentityAccess\AccessProvider\Services\UserRoles;

use Derhub\Shared\Message\Query\AbstractQueryResponse;

final class UserAccessQueryResponse extends AbstractQueryResponse
{
    public function __construct(
        private string $user,
        private array $roles,
        private array $rolePermissions,
    ) {
        parent::__construct(
            [
                'user' => $user,
                'roles' => $roles,
                'role_permissions' => $rolePermissions,
            ]
        );
    }

    public function user(): string
    {
        return $this->user;
    }

    public function roles(): array
    {
        return $this->roles;
    }

    public function rolePermissions(): array
    {
        return $this->rolePermissions;
    }
}