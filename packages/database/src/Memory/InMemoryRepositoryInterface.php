<?php

declare(strict_types=1);

namespace Derhub\Shared\Database\Memory;

use Derhub\Shared\Model\AggregateRepository;

interface InMemoryRepositoryInterface extends AggregateRepository
{
    public function createId(): object;

    public function findById(mixed $id): mixed;

    public function persist(object $object): void;
}
