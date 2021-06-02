<?php

namespace Tests\Shared\Fixtures;

use Derhub\Shared\Message\Message;

class MessageEventFixture implements Message
{
    public const VERSION = 1;

    public function __construct(private string $test)
    {
    }

    public function aggregateRootId(): ?string
    {
        return null;
    }

    public function test(): string
    {
        return $this->test;
    }

    public function version(): int
    {
        return self::VERSION;
    }
}
