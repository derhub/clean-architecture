<?php

namespace Tests\Shared\ValueObject;

use Derhub\Shared\Exceptions\AssertionFailedException;
use Derhub\Shared\Values\Email;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function test_it_fails_error_when_email_is_not_valid(): void
    {
        $this->expectException(AssertionFailedException::class);
        Email::fromString('test');
    }

    public function test_it_accepts_valid_email(): void
    {
        $email = 'test@test.com';
        self::assertEquals($email, Email::fromString($email));
    }
}
