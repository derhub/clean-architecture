<?php

namespace Derhub\Integration\MessageBus;

interface MessageAssembler
{
    public function add(string $className, mixed $mapper): void;

    public function has(string $className): bool;

    public function get(string $className): mixed;

    /**
     * @param class-string $messageClass
     * @param object|array $data
     * @return object
     */
    public function transform(
        string $messageClass,
        object|array $data
    ): object;
}