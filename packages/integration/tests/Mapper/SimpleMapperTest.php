<?php

namespace Tests\Integration\Mapper;

use Derhub\Integration\Mapper\SimpleMapper;
use Tests\Integration\Fixtures\Mapper\ObjectWithCamelCaseParameter;
use Tests\Integration\Fixtures\Mapper\PlainTestClass;
use Tests\Integration\Fixtures\Mapper\TestDefineResolver;
use Tests\Integration\TestCase;

class SimpleMapperTest extends TestCase
{
    public function test_extract(): void
    {
        $mapper = new SimpleMapper();
        $extract = $mapper->extract(
            new PlainTestClass(1, '2', 3),
        );

        self::assertEquals(
            [
                'test' => 1,
                'test2' => '2',
                'test3' => 3,
            ],
            $extract,
        );
    }

    public function test_extract_with_property_name_converter(): void
    {
        $mapper = new SimpleMapper();
        $transform = $mapper->extract(
            new ObjectWithCamelCaseParameter(
                TestDefineResolver::fromInt(1),
                TestDefineResolver::fromString('1'),
                [1]
            ),
        );

        self::assertEquals(
            [
                'camel_case' => TestDefineResolver::fromInt(1),
                'test_dummy' => TestDefineResolver::fromString('1'),
                'test_param' => [1],
            ],
            $transform,
        );
    }
    public function test_transform(): void
    {
        $mapper = new SimpleMapper();
        $transform = $mapper->transform(
            [
                'test' => 1,
                'test2' => '2',
                'test3' => 3,
            ],
            PlainTestClass::class
        );

        self::assertEquals(
            new PlainTestClass(1, '2', 3),
            $transform,
        );
    }

    public function test_transform_with_property_name_converter(): void
    {
        $mapper = new SimpleMapper();
        $transform = $mapper->transform(
            [
                'test_dummy' => TestDefineResolver::fromString('1'),
                'camel_case' => TestDefineResolver::fromInt(1),
                'test_param' => [1],
            ],
            ObjectWithCamelCaseParameter::class
        );

        self::assertEquals(
            new ObjectWithCamelCaseParameter(
                TestDefineResolver::fromInt(1),
                TestDefineResolver::fromString('1'),
                [1]
            ),
            $transform,
        );
    }
}
