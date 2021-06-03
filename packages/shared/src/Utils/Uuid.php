<?php
/**
 * Created By: Johnder Baul<imjohnderbaul@gmail.com>
 * Date: 3/27/21
 */

namespace Derhub\Shared\Utils;

use Ramsey\Uuid\Uuid as BaseUuid;
use Ramsey\Uuid\UuidInterface;

final class Uuid
{
    public static function fromString(string $value): self
    {
        Assert::uuid($value);

        return new self(BaseUuid::fromString($value));
    }

    public static function fromBytes(string $bytes): self
    {
        return new self(BaseUuid::fromBytes($bytes));
    }

    public function toBytes(): string
    {
        return $this->value->getBytes();
    }

    public static function generate(): self
    {
        return new self(BaseUuid::uuid4());
    }

    protected function __construct(protected UuidInterface $value)
    {
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function toString(): string
    {
        return $this->value->toString();
    }

    public function value(): UuidInterface
    {
        return $this->value;
    }
}
