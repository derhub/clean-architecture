<?php

namespace Derhub\Shared\Database\Doctrine;

use Derhub\Shared\Database\DBTransaction;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineDBTransaction implements DBTransaction
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function transaction(callable $callback): mixed
    {
        return $this->entityManager->transactional($callback);
    }

    public function begin(): void
    {
        $this->entityManager->beginTransaction();
    }

    public function commit(): void
    {
        $this->entityManager->commit();
    }

    public function rollback(): void
    {
        $this->entityManager->rollback();
    }
}
