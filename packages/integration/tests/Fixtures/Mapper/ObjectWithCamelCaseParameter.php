<?php

namespace Tests\Integration\Fixtures\Mapper;

class ObjectWithCamelCaseParameter
{
    public function __construct(
        public TestDefineResolver $camelCase,
        public TestDefineResolver $testDummy,
        public array $testParam,
    ) {
    }
}