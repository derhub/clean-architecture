<?php

namespace Tests\Database\Doctrine\Types;

use Derhub\Shared\Database\Doctrine\Types\DbalTyping;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Derhub\Shared\Values\Email;
use PHPUnit\Framework\TestCase;

class DummyClass
{
    use DbalTyping;

    public function convertFromRaw(mixed $value): Email
    {
        return Email::fromString($value);
    }

    public function convertToRaw(mixed $value): string
    {
        return $value->toString();
    }

    public function defineClass(): string
    {
        return Email::class;
    }

    public function defineEmptyValueForPHP(mixed $value): Email
    {
        return new Email();
    }

    public function defineName(): string
    {
        return 'email';
    }
}

class DbalTypingTest extends TestCase
{
    private DummyClass $testClass;

    protected function setUp(): void
    {
        $this->testClass = new DummyClass();
    }

    public function test_it_convert_value_to_php(): void
    {
        $testClass = $this->testClass;

        $platform = $this->getMockForAbstractClass(AbstractPlatform::class);

        $result = $testClass->convertToPHPValue('test@test.com', $platform);

        self::assertInstanceOf(Email::class, $result);
        self::assertEquals(Email::fromString('test@test.com'), $result);
    }

    public function test_it_will_return_empty_value_from_defined_method(): void
    {
        $testClass = $this->testClass;

        $platform = $this->getMockForAbstractClass(AbstractPlatform::class);

        $result1 = $testClass->convertToPHPValue(null, $platform);
        self::assertInstanceOf(Email::class, $result1);

        $result2 = $testClass->convertToPHPValue('', $platform);
        self::assertInstanceOf(Email::class, $result2);
    }

    public function test_it_will_return_value_of_same_instance(): void
    {
        $testClass = $this->testClass;
        $platform = $this->getMockForAbstractClass(AbstractPlatform::class);

        $email = Email::fromString('test@test.com');
        $result = $testClass->convertToPHPValue(
            $email,
            $platform
        );
        self::assertEquals($email, $result);
    }
}
