<?php

namespace Derhub\Laravel\IdentityAccess;

use Derhub\IdentityAccess\Account\Infrastructure\Database\Doctrine\UserAccountDoctrineTypes;
use Derhub\IdentityAccess\Account\Model\PasswordEncryption;
use Derhub\Laravel\IdentityAccess\AuthProvider\IdentityAccessAuthProvider;
use Derhub\Laravel\IdentityAccess\Encryption\PasswordEncryptor;
use Derhub\Shared\Database\Doctrine\DoctrineXmlMetadataRegistry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class IdentityAccessServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        Auth::provider(
            IdentityAccessAuthProvider::NAME,
            static function ($app) {
                return $app->make(IdentityAccessAuthProvider::class);
            },
        );

        Auth::extend(
            IdentityAccessAuthProvider::NAME,
            static function ($app) {
                return $app->make(IdentityAccessAuthProvider::class);
            },
        );
    }

    public function register(): void
    {
        DoctrineXmlMetadataRegistry::addPath(
            __DIR__.'/../../../configs/mapping'
        );

        UserAccountDoctrineTypes::register();

        $this->app->bind(
            PasswordEncryption::class,
            PasswordEncryptor::class
        );
    }
}