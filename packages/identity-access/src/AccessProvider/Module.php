<?php

namespace Derhub\IdentityAccess\AccessProvider;

use Derhub\IdentityAccess\AccessProvider\Services;
use Derhub\Shared\Module\AbstractModule;

class Module extends AbstractModule
{
    public const ID = 'access_provider';

    public function getId(): string
    {
        return self::ID;
    }

    public function start(): void
    {
        $this->registerQuery();
        $this->registerCommand();
    }

    private function registerQuery(): void
    {
        $this
            ->addQuery(
                Services\UserRoles\GetUserRoles::class,
                Services\UserRoles\GetUserRolesHandler::class,
            )
            ->addQuery(
                Services\RolePermission\GetRolesAndPermissions::class,
                Services\RolePermission\GetRolesAndPermissionsHandler::class,
            )
        ;
    }

    private function registerCommand(): void
    {
        $this
            ->addCommand(
                Services\RolePermission\CreateRoleAndPermissions::class,
                Services\RolePermission\CreateRoleAndPermissionsHandler::class,
            )
            ->addCommand(
                Services\RolePermission\RemoveRoles::class,
                Services\RolePermission\RemoveRolesHandler::class,
            )
            ->addCommand(
                Services\RolePermission\UpdateRolePermissions::class,
                Services\RolePermission\UpdateRolePermissionsHandler::class,
            )
        ;
    }
}