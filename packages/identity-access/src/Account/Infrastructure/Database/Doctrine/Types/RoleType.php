<?php

namespace Derhub\IdentityAccess\Account\Infrastructure\Database\Doctrine\Types;

use Cake\Database\Type\StringType;
use Derhub\IdentityAccess\Account\Model\Values\Role;

class RoleType extends StringType
{
    use WithStringTyping;

    public const NAME = 'user_account_role';

    public function defineClass(): string
    {
        return Role::class;
    }
}