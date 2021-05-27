<?php

namespace Tests\Integration\Benchmark;

class TestObjectMapper
{
    /**
     * @Revs(5)
     * @Iterations(5)
     */
    public function benchTransform(): void
    {
        $map = new ObjectMapperConsume();
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
            'increase_by_one'
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
    }

    /**
     * @Revs(5)
     * @Iterations(5)
     */
    public function benchRawTransform(): void
    {
        $map = new RawMapper();
        $map->transform(
            [
                'test1' => 1,
                'test2' => 1,
                'test3' => 1,
                'test4' => 1,
                'test5' => 1,
                'test6' => 1,
                'test7' => 1,
                'test8' => 1,
                'test9' => 1,
                'test0' => 1,
            ],
            TestClassHelper::class
        );
    }

    /**
     * @Revs(5)
     * @Iterations(5)
     */
    public function benchExtract(): void
    {
        $map = new ObjectMapperConsume();
        $map->extract(new TestClassHelper(1, 2, 3, 4, 5, 6, 7, 8, 9, 0));
    }

    /**
     * @Revs(5)
     * @Iterations(5)
     */
    public function benchRawExtract(): void
    {
        $newMap = new RawMapper();
        $newMap->extract(new TestClassHelper(1, 2, 3, 4, 5, 6, 7, 8, 9, 0));
    }
}
