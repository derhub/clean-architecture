<?php

namespace EB\Template\Infrastructure\Specifications\Doctrine;

use Doctrine\ORM\Query\ResultSetMappingBuilder;
use EB\Template\Model\Specification\UniqueSampleSpec;
use EB\Template\Model\Template;
use EB\Template\Model\Specification\UniqueNameSpec;
use Doctrine\ORM\EntityManagerInterface;

class QueryUniqueSampleSpec implements UniqueSampleSpec
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @psalm-param \EB\Template\Model\Specification\UniqueSample $by
     *
     * @return bool
     */
    public function isSatisfiedBy(object $by): bool
    {
        $connection = $this->entityManager->getConnection();
        $expr = $connection->getExpressionBuilder();
        $query = $connection->createQueryBuilder()
            ->select(['1'])
            ->from('`Template`', 'b')
            ->where($expr->eq('b.UniqueSample', '?'))
        ;

        $result = $connection->createQueryBuilder()
            ->select('EXISTS('.$query->getSQL().')')
            ->setParameter(1, $by->name()->toString())
            ->execute()
            ->fetchOne()
        ;

        return $result === '0';
    }
}