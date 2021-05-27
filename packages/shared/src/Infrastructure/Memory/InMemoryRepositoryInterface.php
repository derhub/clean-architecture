<?php

namespace Derhub\Shared\Infrastructure\Memory;

interface InMemoryRepositoryInterface
{
    public function createId(): object;

    public function persist(object $object): void;

    public function findById(mixed $id): mixed;

}
