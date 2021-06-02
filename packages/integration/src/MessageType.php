<?php

namespace Derhub\Integration;

use Derhub\Shared\Utils\Assert;

class MessageType implements \Stringable
{
    public const COMMAND = 'command';
    public const EVENT = 'event';
    public const QUERY = 'query';

    public static function command(): self
    {
        return new self(self::COMMAND);
    }

    public static function event(): self
    {
        return new self(self::EVENT);
    }

    public static function fromString(string $message): self
    {
        Assert::inArray(
            $message,
            [
                self::COMMAND,
                self::QUERY,
                self::EVENT,
            ]
        );

        return new self($message);
    }

    public static function query(): self
    {
        return new self(self::QUERY);
    }

    private function __construct(private string $value)
    {
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function isCommand(): bool
    {
        return $this->value === self::COMMAND;
    }

    public function isEvent(): bool
    {
        return $this->value === self::EVENT;
    }

    public function isQuery(): bool
    {
        return $this->value === self::QUERY;
    }

    public function toString(): string
    {
        return $this->value;
    }
}
