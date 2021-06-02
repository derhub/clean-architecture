<?php

namespace Derhub\Integration;

use Derhub\Shared\Utils\Assert;

class MessageType implements \Stringable
{
    public const COMMAND = 'command';
    public const QUERY = 'query';
    public const EVENT = 'event';

    private function __construct(private string $value)
    {
    }

    public static function command(): self
    {
        return new self(self::COMMAND);
    }

    public function isCommand(): bool
    {
        return $this->value === self::COMMAND;
    }

    public static function query(): self
    {
        return new self(self::QUERY);
    }

    public function isQuery(): bool
    {
        return $this->value === self::QUERY;
    }

    public static function event(): self
    {
        return new self(self::EVENT);
    }

    public function isEvent(): bool
    {
        return $this->value === self::EVENT;
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

    public function __toString(): string
    {
        return $this->toString();
    }

    public function toString(): string
    {
        return $this->value;
    }
}
