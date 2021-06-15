<?php

namespace Tests\IdentityAccess\AccessProvider\Services;

use Derhub\IdentityAccess\AccessProvider\Services\AccessManagerFactory;
use Derhub\IdentityAccess\AccessProvider\Services\UserRoles\UserAccessQueryResponse;
use Derhub\IdentityAccess\AccessProvider\Shared\AccessValues;
use PHPUnit\Framework\TestCase;

class AccessManagerFactoryTest extends TestCase
{
    public function test_createAccessManagerFromQuery(): void
    {
        $rolePermissions = ['post:create', 'post:update', 'post:delete'];
        $roles = ['post admin'];
        $user = 'user1';
        $manager = AccessManagerFactory::createAccessManagerFromQuery(
            new UserAccessQueryResponse(
                $user,
                $roles,
                $rolePermissions,
            )
        );

        self::assertEquals($rolePermissions, $manager->rolePermissions());
        self::assertEquals($user, $manager->user());
        self::assertEquals($roles, $manager->roles());
    }

    public function test_createRoleManager(): void
    {
        $rolePermissions = [
            [
                'role' => 'post admin',
                'permission' => 'post:create',
            ],
            [
                'role' => 'post admin',
                'permission' => 'post:update',
            ],
            [
                'role' => 'post admin',
                'permission' => 'post:delete',
            ],
        ];
        $roles = ['post admin'];
        $manager =
            AccessManagerFactory::createRoleManager($roles, $rolePermissions);

        self::assertTrue($manager->hasRole('post admin'));
        self::assertTrue(
            $manager->hasPermission(
                'post admin', \array_column($rolePermissions, 'permission')
            )
        );
    }

    public function test_createUserPermissionManager(): void
    {
        $rolePermissions = ['post:create', 'post:update', 'post:delete'];
        $roles = ['post admin'];
        $manager =
            AccessManagerFactory::createUserPermissionManager(
                'user1', $roles, $rolePermissions
            );

        self::assertFalse($manager->hasRole('post admin'));
        self::assertTrue($manager->hasRole('user1'));
        self::assertTrue(
            $manager->hasPermission(
                'user1', $rolePermissions
            )
        );


        // test super admin
        $manager =
            AccessManagerFactory::createUserPermissionManager(
                'user1',
                [...$roles, AccessValues::SUPER_ADMIN_ROLE],
                $rolePermissions
            );

        self::assertFalse($manager->hasRole('post admin'));
        self::assertFalse($manager->hasRole('user1'));
        self::assertTrue($manager->hasRootAccess());
        self::assertTrue(
            $manager->hasPermission(
                'root', $rolePermissions
            )
        );
    }
}
