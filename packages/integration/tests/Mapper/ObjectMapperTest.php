<?php

namespace Tests\Integration\Mapper;

use Derhub\Integration\Mapper\InvalidTypeException;
use Derhub\Integration\Mapper\ObjectMapper;
use Derhub\Shared\Utils\Str;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use stdClass;
use Tests\Integration\Benchmark\TestClassHelper;
use Tests\Integration\Fixtures\Mapper\ObjectWithCamelCaseParameter;
use Tests\Integration\Fixtures\Mapper\PlainTestClass;
use Tests\Integration\Fixtures\Mapper\TestDefineResolver;
use Tests\Integration\Fixtures\Mapper\TestWithClassParam;

class ObjectMapperTest extends TestCase
{
    private $mapper;

    protected function setUp(): void
    {
        $this->mapper = new ObjectMapper();
    }

    public function test_it_construct_object_from_array(): void
    {
        $result = $this->mapper->transform(
            [
                'test' => 1,
                'test2' => '2',
                'test3' => 3,
            ],
            PlainTestClass::class
        );

        self::assertEquals(new PlainTestClass(1, 2, 3), $result);
    }

    public function test_it_resolve_by_defined_resolver(): void
    {
        $map = $this->mapper;
        $map->mapMetaData(
            'test_1',
            'test1',
            'increase_by_one'
        );
        $map->mapMetaData(
            'test_2',
            'test2',
            'increase_by_one'
        );
        $map->mapMetaData(
            'test_3',
            'test3',
            'increase_by_one'
        );
        $map->mapMetaData(
            'test_4',
            'test4',
            'increase_by_one'
        );
        $map->mapMetaData(
            'test_5',
            'test5',
            'increase_by_one'
        );
        $map->mapMetaData(
            'test_6',
            'test6',
            'increase_by_one'
        );
        $map->mapMetaData(
            'test_7',
            'test7',
            'increase_by_one'
        );
        $map->mapMetaData(
            'test_8',
            'test8',
            'increase_by_one'
        );

        $map->mapMetaData(
            'test_9',
            'test9',
            'increase_by_one'
        );

        $map->mapMetaData(
            'test_0',
            'test0',
            static fn (int $val) => $val
        );
        $map->defineResolver('increase_by_one', static fn (int $val) => $val);

        $data = [
            'test_1' => 1,
            'test_2' => 1,
            'test_3' => 1,
            'test_4' => 1,
            'test_5' => 1,
            'test_6' => 1,
            'test_7' => 1,
            'test_8' => 1,
            'test_9' => 1,
            'test_0' => 1,
        ];
        $result = $map->transform(
            $data,
            TestClassHelper::class
        );

        self::assertEquals(
            new TestClassHelper(1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
            $result
        );
    }

    public function test_it_accept_array(): void
    {
        $result = $this->mapper->transform(
            [
                'test' => 1,
                'test2' => 2,
                'test6' => 2,
                'test8' => 2,
                'test9' => 2,
            ],
            PlainTestClass::class
        );

        self::assertEquals(new PlainTestClass(1, 2), $result);
    }

    public function test_it_extract_data_from_class(): void
    {
        $this->mapper = new ObjectMapper();
        $this->mapper->mapMetaData(
            name: 'test_test',
            property: 'test',
            resolver: 'test_resolver'
        );

        $this->mapper->defineResolver('test_resolver', fn ($val) => 2);

        $result = $this->mapper->extract(new PlainTestClass(1, 2, 3));
        self::assertEquals(
            [
                'test_test' => 1,
                'test2' => 2,
                'test3' => 3,
            ],
            $result
        );
    }

    public function test_it_fails_when_object_is_not_instantiable(): void
    {
        $this->expectException(ReflectionException::class);
        $this->mapper->transform([], 'test');
    }

    public function test_it_fails_when_object_does_not_have_constructor(): void
    {
        $this->expectException(InvalidTypeException::class);
        $this->mapper->transform([], stdClass::class);
    }

    public function test_it_fails_when(): void
    {
        $this->expectException(InvalidTypeException::class);
        $this->mapper->transform([], stdClass::class);
    }

    public function test_it_fails_when_map_field_with_undefined_resolver(): void
    {
        $this->expectException(InvalidTypeException::class);
        $this->mapper->mapMetaData(
            name: 'test_1',
            property: 'test',
            resolver: 'invalid_resolver'
        );
        $this->mapper->transform(
            [
                'test_1' => 1,
                'test2' => 2,
                'test6' => 2,
                'test8' => 2,
                'test9' => 2,
            ],
            PlainTestClass::class
        );
    }

    public function test_it_accept_resolver_in_array_format(): void
    {
        $this->mapper->mapMetaData(
            name: 'test',
            property: 'test',
            resolver: 'test_resolver'
        );

        $this->mapper->defineResolver(
            'test_resolver',
            [TestDefineResolver::class, 'fromString']
        );

        $result = $this->mapper->transform(
            [
                'test' => '1',
                'test2' => 2,
                'test3' => 3,
            ],
            PlainTestClass::class
        );

        self::assertEquals(
            new PlainTestClass(TestDefineResolver::fromString('1'), 2, 3),
            $result
        );
    }

    /**
     * @throws \ReflectionException
     */
    public function test_it_automatically_resolve(): void
    {
        $objectVal = TestDefineResolver::fromObject(new stdClass());
        $result = $this->mapper->transform(
            [
                'string' => '1',
                'int' => 2,
                'bool' => true,
                'array' => [1, 2, 3, 4, 5],
                'object' => new stdClass(),
                'sameObjectValue' => $objectVal,
            ],
            TestWithClassParam::class
        );

        self::assertEquals(
            new TestWithClassParam(
                TestDefineResolver::fromString('1'),
                TestDefineResolver::fromInt(2),
                TestDefineResolver::fromInt(3),
                TestDefineResolver::fromArray([1, 2, 3, 4, 5]),
                TestDefineResolver::fromObject(new stdClass()),
                $objectVal,
                0,
                null
            ),
            $result
        );

        self::assertSame($objectVal, $result->sameObjectValue);
    }

    public function test_it_get_field_name_using_callback(): void
    {
        $mapper = new ObjectMapper(
            static function ($propertyName) {
                return Str::snakeCase($propertyName);
            }
        );

        $result = $mapper->transform(
            [
                'camel_case' => 1,
                'test_dummy' => true,
                'test_param' => [1, 2, 3],
            ],
            ObjectWithCamelCaseParameter::class,
        );

        $actualParam = [
            'camel_case' => TestDefineResolver::fromInt(1),
            'test_dummy' => TestDefineResolver::fromBoolean(true),
            'test_param' => [1, 2, 3],
        ];
        $actual = new ObjectWithCamelCaseParameter(...array_values($actualParam));
        self::assertEquals(
            $actual,
            $result
        );

        $extract = $mapper->extract($actual);
        self::assertEquals($actualParam, $extract);
    }
}
