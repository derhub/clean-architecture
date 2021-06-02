<?php
/**
 * Created By: Johnder Baul<imjohnderbaul@gmail.com>
 * Date: 3/27/21
 */

namespace Derhub\Shared\Utils;

use Ramsey\Uuid\Uuid as BaseUuid;

final class Uuid
{
    public static function fromString(string $value): self
    {
        Assert::uuid($value);

        return new self($value);
    }

    public static function generate(): self
    {
        return new self(BaseUuid::uuid4()->toString());
    }
    protected function __construct(protected string $value)
    {
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function value(): string
    {
        return $this->value;
    }
}
