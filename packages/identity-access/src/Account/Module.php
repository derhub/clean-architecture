<?php

namespace Derhub\IdentityAccess\Account;

use Derhub\IdentityAccess\Account\Infrastructure\Database\Doctrine\DoctrineQueryUserAccountRepository;
use Derhub\IdentityAccess\Account\Infrastructure\Database\QueryUserAccountRepository;
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

        $this->addDependency(
            QueryUserAccountRepository::class,
            DoctrineQueryUserAccountRepository::class,
        );

        $this->registerCommands();
        $this->registerQueries();
    }

    private function registerCommands(): void
    {
        $this
            ->addCommand(
                Services\Registration\RegisterUserAccount::class,
                Services\Registration\RegisterUserAccountHandler::class,
            )
            ->addCommand(
                Services\Details\UserAccountChangeUserName::class,
                Services\Details\UserAccountChangeUserNameHandler::class,
            )->addCommand(
                Services\Details\UserAccountChangeEmail::class,
                Services\Details\UserAccountChangeEmailHandler::class,
            )->addCommand(
                Services\Details\UserAccountChangePassword::class,
                Services\Details\UserAccountChangePasswordHandler::class,
            )
        ;
    }

    private function registerQueries(): void
    {
        $this
            ->addQuery(
                Services\Query\GetByCredentials::class,
                Services\Query\GetByCredentialsHandler::class,
            )
            ->addQuery(
                Services\Query\GetByUserId::class,
                Services\Query\GetByUserIdHandler::class,
            )
        ;
    }

}
