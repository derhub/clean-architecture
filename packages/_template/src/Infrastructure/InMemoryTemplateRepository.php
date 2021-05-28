<?php

namespace EB\Template\Infrastructure;

use EB\Template\Model\Template;
use EB\Template\Model\TemplateRepository;
use EB\Template\Model\ValueObject\TemplateId;
use EB\Shared\Infrastructure\Memory\InMemoryRepository;
use EB\Shared\Model\AggregateRootId;
use EB\Shared\Utils\Uuid;

/**
 * @extends InMemoryRepository<Template>
 */
class InMemoryTemplateRepository extends InMemoryRepository implements
    TemplateRepository
{
    public function get(TemplateId $aggregateId): ?Template
    {
        return $this->findById($aggregateId);
    }

    /**
     * @psalm-param Template $entity
     */
    public function save(Template $aggregateRoot): void
    {
        $this->persist($aggregateRoot);
    }

    public function getNextId(): TemplateId
    {
        /**
         * @psalm-suppress TypeDoesNotContainNull
         * @psalm-suppress RedundantCondition
         */
        $uuid = self::$fixedId?->toString() ?? Uuid::generate()->toString();

        return TemplateId::fromString($uuid);
    }
}
