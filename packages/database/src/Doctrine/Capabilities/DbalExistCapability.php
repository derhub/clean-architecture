<?php

namespace Derhub\Shared\Database\Doctrine\Capabilities;

use Derhub\Shared\Query\FailedQueryException;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Exception;

trait DbalExistCapability
{
    abstract public function getConnection(): Connection;
    abstract public function getTableName(): string;

    /**
     * @throws \Derhub\Shared\Query\FailedQueryException
     */
    public function exists(string $field, mixed $value): bool
    {
        $connection = $this->getConnection();
        $expr = $connection->getExpressionBuilder();
        $query = $connection->createQueryBuilder()
            ->select(['1'])
            ->from(sprintf('`%s`', $this->getTableName()), 'b')
            ->where($expr->eq('b.'.$field, '?'))
        ;

        try {
            $result = $connection->createQueryBuilder()
                ->select('EXISTS('.$query->getSQL().')')
                ->setParameter(1, $value)
                ->execute()
                ->fetchOne()
            ;
        } catch (\Doctrine\DBAL\Exception | Exception $e) {
            throw FailedQueryException::fromThrowable($e);
        }

        return $result === '0';
    }
}