<?php

namespace Tests\Integration\Benchmark;

use Derhub\Shared\ObjectMapper\ObjectMapperInterface;

class RawMapper implements ObjectMapperInterface
{
    public function transform(object|array $data, string $object): mixed
    {
        return new $object(
            $data['test1'],
            $data['test2'],
            $data['test3'],
            $data['test4'],
            $data['test5'],
            $data['test6'],
            $data['test7'],
            $data['test8'],
            $data['test9'],
            $data['test0'],
        );
    }

    public function extract(object $object): array
    {
        return [
            'test1' => $object->test1(),
            'test2' => $object->test2(),
            'test4' => $object->test4(),
            'test5' => $object->test5(),
            'test6' => $object->test6(),
            'test7' => $object->test7(),
            'test8' => $object->test8(),
            'test9' => $object->test9(),
            'test0' => $object->test0(),
        ];
    }
}
