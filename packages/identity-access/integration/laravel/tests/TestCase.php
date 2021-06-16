<?php

namespace Tests\Integration\Laravel\IdentityAccess;


use Derhub\IdentityAccess\Account\Services\Registration\RegisterUserAccount;
use Derhub\Laravel\IdentityAccess\AuthProvider\IdentityAccessAuthProvider;
use Derhub\Shared\Message\Command\CommandBus;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected bool $loadEnvironmentVariables = true;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase();
    }

    protected function getPackageProviders($app): array
    {
        return [
            IdentityAccessAuthProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set(
            'database.connections.sqlite',
            [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ]
        );

        $app['config']->set(
            'auth.guards.web.provider',
            IdentityAccessAuthProvider::NAME,
        );

        $app['config']->set(
            'auth.defaults.passwords',
            IdentityAccessAuthProvider::NAME,
        );

        $app['config']->set(
            'auth.defaults.passwords',
            IdentityAccessAuthProvider::NAME,
        );

        $app['config']->set(
            'auth.providers.'.IdentityAccessAuthProvider::NAME,
            [
                'driver' => IdentityAccessAuthProvider::NAME,
                'provider' => IdentityAccessAuthProvider::NAME,
            ]
        );
    }

    private function setUpDatabase(): void
    {
        $userTable =
            require __DIR__.'/../database/migrations/create_users_table.php';
        $passwordTable =
            require __DIR__.'/../database/migrations/create_password_reset_table.php';
        $rolesTable =
            require __DIR__.'/../database/migrations/create_roles_table.php';
        $permissionTable =
            require __DIR__.'/../database/migrations/create_role_permissions_table.php';
        $userRolesTable =
            require __DIR__.'/../database/migrations/create_user_roles_table.php';

        $userTable->up();
        $passwordTable->up();
        $rolesTable->up();
        $permissionTable->up();
        $userRolesTable->up();
    }

    public function test_auth_login_methods(): void
    {
        $email = 'test@test.com';
        $password = 'test';
        $username = 'test';

        /** @var CommandBus $bus */
        $bus = $this->app->make(CommandBus::class);
        $bus->dispatch(
            new RegisterUserAccount(
                username: $username,
                password: $password,
                email: $email,
            )
        );

        $loginByEmail = Auth::attempt(
            [
                'email' => $email,
                'password' => $password,
            ]
        );

        self::assertTrue($loginByEmail);

        $loginByUsername = Auth::attempt(
            [
                'username' => $username,
                'password' => $password,
            ]
        );

        self::assertTrue($loginByUsername);

        $failLogin = Auth::attempt(
            [
                'username' => 'failedlogin',
                'password' => 'failedlogin',
            ]
        );

        self::assertFalse($failLogin);
    }
}