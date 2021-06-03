# Database Module

Manage orm integration, migration and testing

## Database integration supports:

### Doctrine https://www.doctrine-project.org/

We have two repository for persistence and query

1. `Derhub\Shared\Database\Doctrine\DoctrinePersistenceRepository` for aggregate
  persistence
```php
// sample usage
use Derhub\Shared\Persistence\DatabasePersistenceRepository;

class YourAggregatePersistenceRepository implements YourAggregateRepository
{
    public function __construct(
        private DatabasePersistenceRepository $persistence
    ) {
        $this->persistence->setAggregateClass(YourAggregate::class);
    }

    public function get(AggregateRootId $id): YourAggregrateClass
    {
        return $this->persistence->findById($id->toString());
    }

    public function getNextId(): YourAggregateId
    {
        return YourAggregateId::generate();
    }

    public function save(AggregateRoot $aggregateRoot): void
    {
        $this->persistence->persist($aggregateRoot);
    }
}
```

2. `Derhub\Shared\Database\Doctrine\DoctrineQueryRepository` for query or reading
  the data

```php

use Derhub\Shared\Database\Doctrine\DoctrineQueryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
/**
 * @template-extends AbstractDoctrineQueryRepository<Business>
 */
class DoctrineQueryBusinessRepository extends DoctrineQueryRepository implements QueryYourAggregateRepository
{
    public function __construct(
        EntityManagerInterface $entityManager,
        BusinessQueryItemMapper $mapper
    ) {
        parent::__construct($entityManager, $mapper);
    }

    protected function getRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(YourAggregate::class);
    }

    protected function getTableName(): string
    {
        // this is use when checking if data exist
        return 'your database table';
    }
}

```

resources:

- 

### InMemory

## Migration https://phinx.org/

1. create config `php ./vendor/bin/phinx init`
2. create migration `php ./vendor/bin/phinx create MyNewMigration`
3. create seeder `php ./vendor/bin/phinx seed:create MyNewMigration`


note:
 - modules directories: 'modulePath/db/{migrations or seeders}' see the sample 
   config `phinx.php.example`
 - for framework integration run the init command then update migrations and seeders
   path sample: `__DIR__.'/vendor/derhub/*/db/migrations', __DIR__.'/vendor/derhub/*/db/seeder'`