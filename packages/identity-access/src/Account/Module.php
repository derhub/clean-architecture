<?php

namespace Derhub\IdentityAccess\Account;

use Derhub\IdentityAccess\Account\Model;
use Derhub\Shared\Module\ModuleCapabilities;
use Derhub\Shared\Module\ModuleInterface;
use Derhub\IdentityAccess\Account\Infrastructure\Database;
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
            Model\UserAccountRepository::class,
            Database\UserAccountPersistenceRepository::class,
        );

        $this->addDependency(
            Database\QueryUserAccountRepository::class,
            Database\Doctrine\DoctrineQueryUserAccountRepository::class,
        );

        $this->addDependency(
            Model\ComparePassword::class,
            Services\ComparePasswordService::class
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
                Services\DetailsUpdate\ChangeUserAccountUsername::class,
                Services\DetailsUpdate\ChangeUserAccountUsernameHandler::class,
            )->addCommand(
                Services\DetailsUpdate\ChangeUserAccountEmail::class,
                Services\DetailsUpdate\ChangeUserAccountEmailHandler::class,
            )->addCommand(
                Services\DetailsUpdate\ChangeUserAccountPassword::class,
                Services\DetailsUpdate\ChangeUserAccountPasswordHandler::class,
            )
        ;
    }

    private function registerQueries(): void
    {
        $this
            ->addQuery(
                Services\Query\GetByEmail::class,
                Services\Query\GetByEmailHandler::class,
            )
            ->addQuery(
                Services\Query\GetByUsername::class,
                Services\Query\GetByUsernameHandler::class,
            )
            ->addQuery(
                Services\Query\GetByUserId::class,
                Services\Query\GetByUserIdHandler::class,
            )
        ;
    }

}
