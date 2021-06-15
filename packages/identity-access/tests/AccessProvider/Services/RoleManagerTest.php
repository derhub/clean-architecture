<?php

namespace Tests\IdentityAccess\AccessProvider\Services;

use Derhub\IdentityAccess\AccessProvider\Services\Role;
use Derhub\IdentityAccess\AccessProvider\Services\RoleManager;
use Derhub\IdentityAccess\AccessProvider\Shared\AccessValues;
use PHPUnit\Framework\TestCase;

class RoleManagerTest extends TestCase
{
    public function test_add_read_and_remove_role(): void
    {
        $role1 = new Role('test1');
        $rbac = new RoleManager([new Role('test6')]);
        $rbac->addRole(new Role('test'));
        $rbac->addRole($role1);
        $rbac->addRole(new Role('test2'));
        $rbac->addRole(new Role('test3'));
        $rbac->removeRole(new Role('test2'));
        $rbac->removeRole('test3');
        $rbac->removeRole('will not throw error');

        self::assertTrue($rbac->hasRole('test'));
        self::assertTrue($rbac->hasRole($role1));
        self::assertEquals($role1, $rbac->getRole('test1'));
        self::assertFalse($rbac->hasRole('test2'));
        self::assertFalse($rbac->hasRole('test3'));

        self::assertEquals(['test6', 'test', 'test1'], \array_keys($rbac->roles()));
    }

    public function test_access_checks(): void
    {
        $role = new Role('test');
        $rbac = new RoleManager([$role]);
        $rbac->addPermissions(
            'test', ['create', 'delete', 'update', ['view', 'view owned']]
        );
        self::assertTrue($rbac->hasPermission($role, ['create', 'view']));
        self::assertFalse(
            $rbac->hasPermission($role, ['create', 'view', 'none'])
        );

        $rbac->removePermissions($role, 'create');
        $rbac->removePermissions('test', 'delete');
        self::assertFalse($rbac->hasPermission($role, ['create', 'view']));
        self::assertFalse($rbac->hasPermission($role, 'delete'));
    }

    public function test_error_on_not_exist_role(): void
    {
        $role = new Role('test');
        $rbac = new RoleManager([$role]);

        $this->expectException(\InvalidArgumentException::class);
        $rbac->hasPermission('error', 'error');
    }

    public function test_root_access(): void
    {
        $rbac = new RoleManager();
        $rbac->addRole(new Role(AccessValues::SUPER_ADMIN_ROLE));
        self::assertTrue($rbac->hasRootAccess());
        self::assertTrue(
            $rbac->hasPermission(AccessValues::SUPER_ADMIN_ROLE, [])
        );

        $rbac = new RoleManager();
        $rbac->addRole(new Role('test'));
        self::assertFalse($rbac->hasRootAccess());
        self::assertFalse($rbac->hasPermission('test', 'any'));
    }

}
