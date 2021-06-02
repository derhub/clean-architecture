<?php

namespace Tests\Template\Services;

use Derhub\Integration\TestUtils\MessageTestCase;
use Derhub\Template\AggregateExample\Infrastructure\Database\InMemoryRepository;
use Derhub\Template\AggregateExample\Model\Values\TemplateId;
use Tests\Template\GetModule;
use Tests\Template\Stub\QueryRepositoryStub;

abstract class ServiceTestCase extends MessageTestCase
{
    use GetModule;

    protected ?TemplateId $lastId;
    protected QueryRepositoryStub $queryRepo;

    public function setUp(): void
    {
        parent::setUp();
        $this->queryRepo = new QueryRepositoryStub();

        $handler = $this->getHandler();
        $this->container->add(
            $handler::class,
            fn () => $handler,
        );
        $this->lastId = null;
    }

    protected function createId(): object
    {
        return $this->lastId = TemplateId::generate();
    }

    abstract protected function getHandler(): object;

    protected function getRepository(): InMemoryRepository
    {
        return new InMemoryRepository();
    }
}
