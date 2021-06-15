<?php

namespace Tests\IdentityAccess\AccessProvider\Services;

use Derhub\IdentityAccess\AccessProvider\Services\Role;
use PHPUnit\Framework\TestCase;

class RoleTest extends TestCase
{
    public function test_allow_permissions(): void
    {
        $role = new Role('member');

        $role->removePermissions('create');
        $role->addPermissions('delete', 'view');
        $role->addPermissions(['activate', 'deactivate']);
        $role->addPermissions('test1', ['activate', 'deactivate'], 'test2');

        self::assertEquals('member', $role->name());
        self::assertEquals(
            [
                'delete' => 'delete',
                'view' => 'view',
                'test1' => 'test1',
                'test2' => 'test2',
                'activate' => 'activate',
                'deactivate' => 'deactivate',
            ],
            $role->permissions()
        );

        self::assertFalse($role->hasPermissions('create'));
        self::assertFalse($role->hasPermissions('create', 'delete'));
        //
        self::assertTrue($role->hasPermissions('view', 'delete'));
        self::assertTrue(
            $role->hasPermissions('delete', ['activate', 'deactivate'])
        );
    }

    public function test_deny_permissions(): void
    {
        $role = new Role('member');

        $role->addPermissions('create');
        $role->removePermissions('delete', 'view');
        $role->removePermissions(['activate', 'deactivate']);
        $role->removePermissions('test1', ['activate', 'deactivate'], 'test2');

        self::assertEquals(
            [
                'create' => 'create',
            ],
            $role->permissions()
        );

        self::assertFalse($role->hasPermissions('create', 'delete'));
        self::assertFalse(
            $role->hasPermissions('create', ['activate', 'deactivate'])
        );

        self::assertTrue($role->hasPermissions('create'));
        self::assertFalse($role->hasPermissions('activate'));
        self::assertFalse($role->hasPermissions(['activate', 'deactivate']));
        self::assertFalse(
            $role->hasPermissions(['Missing permission is denied'])
        );
    }

    public function test_wildcard_permissions(): void
    {
        $role = new Role(
            'wildcard',
            [
                'm:test_module:*' => 'm:test_module:*',
            ]
        );

        $role->addPermissions('m:test_module2:create');
        $role->addPermissions('m:test_module2:update');
        $role->removePermissions('m:test_module2:update');

        self::assertEquals(
            [
                'm:test_module2:create' => 'm:test_module2:create',
                'm:test_module:*' => 'm:test_module:*',
            ],
            $role->permissions()
        );

        self::assertFalse($role->hasPermissions('m:test_module2:update'));
        self::assertTrue($role->hasPermissions('m:test_module:update'));
        self::assertTrue($role->hasPermissions('m:test_module:*'));

        $this->expectException(
            \Derhub\Shared\Exceptions\AssertionFailedException::class
        );
        $role->addPermissions(['m:*:2']);
    }

    public function test_root_access(): void
    {
        $role = new Role('root');
        self::assertEquals('root', $role->name());
        self::assertTrue($role->hasRootAccess());
        self::assertTrue($role->hasPermissions('any value here 1'));

        $this->expectException(\Exception::class);
        $role->addPermissions('error any value here 3');
    }

    public function test_to_string(): void
    {
        $role = new Role('root');
        self::assertEquals('root', (string)$role);
    }
}
