<?php

namespace Tests\Integration\Fixtures\Mapper;

class PlainTestClass
{
    public function __construct(
        private mixed $test,
        protected string $test2,
        public int $test3 = 1234,
    ) {
    }

    public function test(): mixed
    {
        return $this->test;
    }

    public function test2(): string
    {
        return $this->test2;
    }

    public function test3(): int
    {
        return $this->test3;
    }
}
