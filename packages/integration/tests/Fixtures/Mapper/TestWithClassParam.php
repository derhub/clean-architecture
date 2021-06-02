<?php

namespace Tests\Integration\Fixtures\Mapper;

class TestWithClassParam
{
    public function __construct(
        public TestDefineResolver $string,
        public TestDefineResolver $int,
        public TestDefineResolver $bool,
        public TestDefineResolver $array,
        public TestDefineResolver $object,
        public TestDefineResolver $sameObjectValue,
        public int $default = 0,
        public ?int $nullable = null,
    ) {
    }
}
