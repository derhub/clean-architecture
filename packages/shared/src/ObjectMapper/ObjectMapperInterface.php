<?php

namespace Derhub\Shared\ObjectMapper;

interface ObjectMapperInterface
{
    public function extract(object $object): array;
    /**
     * @param array|object $data
     * @param class-string $object
     * @return mixed
     */
    public function transform(array|object $data, string $object): mixed;
}
