<?php

namespace EB\Template\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use EB\Template\Model\Template;
use EB\Template\Model\TemplateRepository;
use EB\Template\Model\ValueObject\TemplateId;
use EB\Shared\Utils\Str;

class DoctrineTemplateRepository implements TemplateRepository
{
    public function __construct(private EntityManagerInterface $manager)
    {
    }

    /**
     * @psalm-return ?Template
     */
    public function get(\EB\Shared\Model\AggregateRootId $aggregateId): ?Template
    {
        /** @var ?Template $find */
        $find = $this->manager->find(Template::class, $aggregateId);
        return $find;
    }

    public function save(object $entity): void
    {
        $this->manager->persist($entity);
        $this->manager->flush();
    }

    public function getNextId(): TemplateId
    {
        return TemplateId::generate();
    }
}
