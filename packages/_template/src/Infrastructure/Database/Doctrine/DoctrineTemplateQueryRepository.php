<?php

namespace Derhub\Template\Infrastructure\Database\Doctrine;

use Derhub\Template\Services\BusinessQueryItemMapper;
use Derhub\Shared\Query\QueryItemMapper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Derhub\Template\Shared\SharedValues;
use Derhub\Template\Infrastructure\Database\TemplateQueryRepository;
use Derhub\Template\Model\Template;
use Derhub\Shared\Database\Doctrine\DoctrineQueryRepository;

/**
 * @template-extends AbstractDoctrineQueryRepository<Business>
 */
class DoctrineTemplateQueryRepository extends DoctrineQueryRepository
    implements TemplateQueryRepository
{
    public function __construct(
        EntityManagerInterface $entityManager,
        BusinessQueryItemMapper $mapper
    ) {
        parent::__construct($entityManager, $mapper);
    }

    protected function getTableName(): string
    {
        return SharedValues::TABLE_NAME;
    }

    protected function getRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(Template::class);
    }

}