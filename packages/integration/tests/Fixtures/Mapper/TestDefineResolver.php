<?php

namespace Tests\Integration\Fixtures\Mapper;

class TestDefineResolver
{
    public mixed $value;

    public function __construct()
    {
        $this->value = null;
    }

    public static function fromString(string $test): self
    {
        $s = new self();
        $s->value = $test;

        return $s;
    }

    public static function fromArray(array $test): self
    {
        $s = new self();
        $s->value = $test;

        return $s;
    }

    public static function fromInt(int $test): self
    {
        $s = new self();
        $s->value = $test;

        return $s;
    }

    public static function fromBoolean(bool $test): self
    {
        $s = new self();
        $s->value = $test;

        return $s;
    }

    public static function fromObject(object $obj): self
    {
        $s = new self();
        $s->value = $obj;

        return $s;
    }
}
