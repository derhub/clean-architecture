<?php

namespace Derhub\IdentityAccess\Account\Services;

use Derhub\IdentityAccess\Account\Model\ComparePassword;
use Derhub\IdentityAccess\Account\Model\PasswordEncryption;

class ComparePasswordService implements ComparePassword
{
    public function __construct(
        private PasswordEncryption $encrypt
    ) {
    }

    public function compare(string $plainPassword, string $hashedPassword): bool
    {
        if (empty($plainPassword)) {
            return false;
        }

        return $this->encrypt->compareFromPlain(
            $plainPassword,
            $hashedPassword
        );
    }

}