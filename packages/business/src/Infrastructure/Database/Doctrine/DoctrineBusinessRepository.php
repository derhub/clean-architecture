<?php

namespace Derhub\Business\Infrastructure\Database\Doctrine;

use Derhub\Shared\Database\Doctrine\DoctrinePersistenceRepository;
use Derhub\Business\Model\BusinessRepository;
use Derhub\Business\Model\Values\BusinessId;
use Doctrine\ORM\EntityRepository;
use Derhub\Business\Model\Business;

/**
 * @template-extends DoctrinePersistenceRepository<Business>
 */
class DoctrineBusinessRepository extends DoctrinePersistenceRepository
    implements BusinessRepository
{
    public function getNextId(): BusinessId
    {
        return BusinessId::generate();
    }

    protected function getDoctrineRepo(): EntityRepository
    {
        return $this->entityManager->getRepository(Business::class);
    }
}
