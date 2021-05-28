<?php

namespace Tests\Database\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Derhub\Shared\Database\Doctrine\Types\EmailType;
use Derhub\Shared\Values\Email;
use PHPUnit\Framework\TestCase;

class EmailTypeTest extends TestCase
{
    public function test_it_convert_value_base_on_class_string(): void
    {
        $platform = $this->getMockForAbstractClass(AbstractPlatform::class);

        $email = new EmailType();
        $result = $email->convertToPHPValue('test@test.com', $platform);

        self::assertEquals(Email::fromString('test@test.com'), $result);
    }
}
