<?php

namespace Tests\Integration\Benchmark;

class TestClassHelper
{
    public function __construct(
        private string $test1,
        private string $test2,
        private string $test3,
        private string $test4,
        private string $test5,
        private string $test6,
        private string $test7,
        private string $test8,
        private string $test9,
        private string $test0,
    ) {
    }

    public function test1(): string
    {
        return $this->test1;
    }

    public function test2(): string
    {
        return $this->test2;
    }

    public function test3(): string
    {
        return $this->test3;
    }

    public function test4(): string
    {
        return $this->test4;
    }

    public function test5(): string
    {
        return $this->test5;
    }

    public function test6(): string
    {
        return $this->test6;
    }

    public function test7(): string
    {
        return $this->test7;
    }

    public function test8(): string
    {
        return $this->test8;
    }

    public function test9(): string
    {
        return $this->test9;
    }

    public function test0(): string
    {
        return $this->test0;
    }
}
