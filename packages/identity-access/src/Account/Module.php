<?php

namespace Derhub\IdentityAccess\Account;

use Derhub\Shared\Module\ModuleCapabilities;
use Derhub\Shared\Module\ModuleInterface;
use Derhub\IdentityAccess\Account\Infrastructure\Database\UserAccountPersistenceRepository;
use Derhub\IdentityAccess\Account\Model\UserAccountRepository;
use Derhub\IdentityAccess\Account\Services;

final class Module implements ModuleInterface
{
    use ModuleCapabilities;

    public const ID = 'user_account';

    public function getId(): string
    {
        return self::ID;
    }

    public function start(): void
    {
        $this->addDependency(
            UserAccountRepository::class,
            UserAccountPersistenceRepository::class,
        );
        
        $this->addCommand(
            Services\Authentication\AuthenticateUser::class,
            Services\Authentication\AuthenticateUserHandler::class,
        );

        $this->registerAuthorization();
        $this->registerRoles();
    }

    public function registerAuthorization(): void
    {
        $this
            ->addCommand(
                Services\Authorization\AssignRolesToUser::class,
                Services\Authorization\AssignRolesToUserHandler::class,
            )
            ->addCommand(
                Services\Authorization\AuthorizeUserResource::class,
                Services\Authorization\AuthorizeUserResourceHandler::class,
            )
            ->addCommand(
                Services\Authorization\RemoveRolesToUser::class,
                Services\Authorization\RemoveRolesToUserHandler::class,
            )
        ;
    }

    private function registerRoles(): void
    {
        $this
            ->addCommand(
                Services\RoleAndPermissions\AssignPermissionsToRole::class,
                Services\RoleAndPermissions\AssignPermissionsToRoleHandler::class,
            )
            ->addCommand(
                Services\RoleAndPermissions\NewRole::class,
                Services\RoleAndPermissions\NewRoleHandler::class,
            )
            ->addCommand(
                Services\RoleAndPermissions\RemoveRole::class,
                Services\RoleAndPermissions\RemoveRoleHandler::class,
            )
            ->addCommand(
                Services\RoleAndPermissions\RemoveRolePermissions::class,
                Services\RoleAndPermissions\RemoveRolePermissionsHandler::class,
            )
        ;
    }
}
