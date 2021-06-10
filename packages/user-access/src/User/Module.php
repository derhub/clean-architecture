<?php

namespace Derhub\UserAccess\User;

use Derhub\Shared\Module\ModuleCapabilities;
use Derhub\Shared\Module\ModuleInterface;
use Derhub\UserAccess\User\Model;
use Derhub\UserAccess\User\Services;

final class Module implements ModuleInterface
{
    use ModuleCapabilities;

    public const ID = 'template';

    public function getId(): string
    {
        return self::ID;
    }

    public function start(): void
    {
        $this->registerCommands();
    }

    public function registerCommands(): void
    {
        $this
            ->addCommand(
                Services\TokenAuthentication\AuthenticateUserToken::class,
                Services\TokenAuthentication\AuthenticateUserTokenHandler::class,
            )
            ->addCommand(
                Services\Authorization\AuthorizeUser::class,
                Services\Authorization\AuthorizeUserHandler::class,
            )
            ->addCommand(
                Services\Authentication\AuthenticateUser::class,
                Services\Authentication\AuthenticateUserHandler::class,
            )
        ;
    }
}
