<?php

namespace EB\Template\Infrastructure\Query\Doctrine;

use Doctrine\Persistence\ObjectRepository;
use EB\Shared\Query\Doctrine\AbstractDoctrineQueryRepository;
use EB\Template\Infrastructure\Query\TemplateQueryRepository;
use EB\Template\Model\Template;

class DoctrineQueryRepository extends AbstractDoctrineQueryRepository implements TemplateQueryRepository
{

    protected function getRepository(): ObjectRepository
    {
        return $this->entityManager->getRepository(Template::class);
    }

    protected function getTableName(): string
    {

    }
}