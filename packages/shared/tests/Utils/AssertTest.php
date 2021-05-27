<?php

namespace Tests\Shared\Utils;

use Derhub\Shared\Exceptions\AssertionFailedException;
use Derhub\Shared\Utils\Assert;
use PHPUnit\Framework\TestCase;

class AssertTest extends TestCase
{
    /**
     * @test
     */
    public function it_asserts_mobile_phone_number(): void
    {
        self::assertTrue(Assert::phone('+639084491007'));

        $this->expectException(AssertionFailedException::class);
        self::assertTrue(Assert::phone('639084491007'));
    }
}
