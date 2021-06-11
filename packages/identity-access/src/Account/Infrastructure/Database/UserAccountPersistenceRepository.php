<?php

namespace Derhub\IdentityAccess\Account\Infrastructure\Database;

use Derhub\Shared\Model\AggregateRoot;
use Derhub\Shared\Model\AggregateRootId;
use Derhub\Shared\Persistence\PersistenceRepository;
use Derhub\IdentityAccess\Account\Model\UserAccount;
use Derhub\IdentityAccess\Account\Model\UserAccountRepository;
use Derhub\IdentityAccess\Account\Model\Values\UserId;

class UserAccountPersistenceRepository implements UserAccountRepository
{
    public function __construct(private PersistenceRepository $repo)
    {
        $this->repo->setAggregateClass(UserAccount::class);
    }

    public function get(AggregateRootId $id): ?UserAccount
    {
        /** @var \Derhub\IdentityAccess\Account\Model\Values\UserId $id */
        return $this->repo->findById($id->toBytes());
    }

    public function getNextId(): UserId
    {
        return UserId::generate();
    }

    public function save(AggregateRoot $aggregateRoot): void
    {
        $this->repo->persist($aggregateRoot);
    }
}