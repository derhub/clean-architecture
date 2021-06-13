<?php

namespace Derhub\IdentityAccess\Account\Infrastructure\Database\Doctrine;

use Derhub\IdentityAccess\Account\Infrastructure\Database\QueryUserAccountRepository;
use Derhub\IdentityAccess\Account\Model\UserAccount;
use Derhub\IdentityAccess\Account\Services\UserAccountMapper;
use Derhub\IdentityAccess\Account\Shared\UserAccountValues;
use Derhub\Shared\Database\Doctrine\DoctrineQueryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrineQueryUserAccountRepository extends DoctrineQueryRepository
    implements QueryUserAccountRepository
{
    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        parent::__construct($entityManager);
        $this->setMapper(new UserAccountMapper());
    }

    protected function getRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(UserAccount::class);
    }

    protected function getTableName(): string
    {
        return UserAccountValues::TABLE_NAME;
    }
}