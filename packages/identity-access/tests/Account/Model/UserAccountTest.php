<?php

namespace Tests\UserAccess\Account\Model;

use Derhub\Shared\Model\DomainEvent;
use Derhub\UserAccess\Account\Model\Event\UserAccountEmailChanged;
use Derhub\UserAccess\Account\Model\Event\UserAccountPasswordChanged;
use Derhub\UserAccess\Account\Model\Event\UserAccountRegistered;
use Derhub\UserAccess\Account\Model\Event\UserAccountUsernameChanged;
use Derhub\UserAccess\Account\Model\Roles;
use Derhub\UserAccess\Account\Model\UserAccount;
use Derhub\UserAccess\Account\Model\Values\Email;
use Derhub\UserAccess\Account\Model\Values\Password;
use Derhub\UserAccess\Account\Model\Values\UserId;
use Derhub\UserAccess\Account\Model\Values\Username;
use PHPUnit\Framework\TestCase;

class UserAccountTest extends TestCase
{

    /**
     * @param array<class-string> $actual
     * @param \Derhub\Shared\Model\DomainEvent[] $events
     */
    private static function assertEvents(array $actual, array $events): void
    {
        $classStringEvents =
            array_map(static fn (DomainEvent $e) => $e::class, $events);
        self::assertEquals($actual, $classStringEvents);
    }

    public function createModel(): UserAccount
    {
        return new UserAccount(UserId::generate());
    }

    public function testRegister(): void
    {
        $model = UserAccount::register(
            userId: UserId::generate(),
            email: Email::fromString('test@test.com'),
            username: Username::fromString('test12'),
            password: Password::fromString('test'),
            roles: new Roles(),
        );

        self::assertEvents(
            [
                UserAccountRegistered::class,
            ],
            $model->pullEvents(),
        );
    }

    public function testChangeEmail(): void
    {
        $model = $this->createModel();
        $model->changeEmail(Email::fromString('test@test2.com'));
        self::assertEvents(
            [
                UserAccountEmailChanged::class,
            ],
            $model->pullEvents(),
        );
    }

    public function testChangeUsername(): void
    {
        $model = $this->createModel();
        $model->changeUsername(Username::fromString('testcom'));
        self::assertEvents(
            [
                UserAccountUsernameChanged::class,
            ],
            $model->pullEvents(),
        );
    }

    public function testChangePassword(): void
    {
        $model = $this->createModel();
        $model->changePassword(Password::fromString('testcom'));
        self::assertEvents(
            [
                UserAccountPasswordChanged::class,
            ],
            $model->pullEvents(),
        );
    }
}
