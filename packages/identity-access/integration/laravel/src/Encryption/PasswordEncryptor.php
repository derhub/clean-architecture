<?php

namespace Derhub\Laravel\IdentityAccess\Encryption;

use Derhub\IdentityAccess\Account\Model\PasswordEncryption;
use Illuminate\Contracts\Hashing\Hasher;

class PasswordEncryptor implements PasswordEncryption
{
    public function __construct(private Hasher $hasher)
    {
    }

    public function encrypt(string $text): string
    {
        return $this->hasher->make($text);
    }

    public function compareFromPlain(string $text, string $encryptedText): bool
    {
        return $this->hasher->check($text, $encryptedText);
    }
}