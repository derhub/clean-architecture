<?php

namespace Derhub\Shared\Encryption;

interface TextEncryption
{
    public function encrypt(string $text): string;

    public function compareFromPlain(string $text, string $encryptedText): bool;
}