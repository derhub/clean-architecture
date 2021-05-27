<?php

namespace Derhub\Business\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Derhub\Business\Model\Business;
use Derhub\Business\Model\BusinessRepository;
use Derhub\Business\Model\Values\BusinessId;
use Derhub\Business\Model\Values\Name;
use Derhub\Business\Model\Values\Slug;
use Derhub\Shared\Message\Event\EventBus;
use Derhub\Shared\Utils\Str;

class DoctrineBusinessRepository implements BusinessRepository
{
    public function __construct(
        private EntityManagerInterface $manager,
//        private EventBus $eventDispatcher
    ) {
    }

    /**
     * @psalm-return ?Business
     */
    public function get(mixed $id): ?Business
    {
        /** @var ?Business $find */
        $find = $this->manager->find(Business::class, $id);
        return $find;
    }

    public function save(object $entity): void
    {
//        $events = $entity->pullEvents();
//        if (! empty($events)) {
//            $this->eventDispatcher->dispatch(...$events);
//        }

        $this->manager->persist($entity);
        $this->manager->flush();
    }

    public function getNextId(): BusinessId
    {
        return BusinessId::generate();
    }
}
