<?php

namespace Derhub\Template\AggregateExample\Infrastructure\Database\Doctrine;

use Derhub\Shared\Database\Doctrine\DoctrineQueryRepository;
use Derhub\Template\AggregateExample\Infrastructure\Database\TemplateQueryRepository;
use Derhub\Template\AggregateExample\Model\Template;
use Derhub\Template\AggregateExample\Services\TemplateQueryItemMapper;
use Derhub\Template\AggregateExample\Shared\SharedValues;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * @template-extends AbstractDoctrineQueryRepository<Business>
 */
class DoctrineTemplateQueryRepository extends DoctrineQueryRepository implements TemplateQueryRepository
{
    public function __construct(
        EntityManagerInterface $entityManager,
        TemplateQueryItemMapper $mapper
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
