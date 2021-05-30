<?php

namespace Tests\Template\Services;

use Derhub\Integration\TestUtils\MessageTestCase;
use Derhub\Shared\ModuleInterface;
use Derhub\Template\Infrastructure\Database\InMemoryRepository;
use Derhub\Template\Model\Values\TemplateId;
use Derhub\Template\Module;
use Tests\Template\Stub\QueryRepositoryStub;

abstract class ServiceTestCase extends MessageTestCase
{
    /**
     * @var \Derhub\Template\Model\Values\TemplateId
     */
    protected ?TemplateId $lastId;
    /**
     * @var \Tests\Template\Stub\QueryRepositoryStub
     */
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

    abstract protected function getHandler(): object;

    protected function getModule(): ModuleInterface
    {
        return new Module();
    }

    protected function createId(): object
    {
        return $this->lastId = TemplateId::generate();
    }

    protected function getRepository(): InMemoryRepository
    {
        return new InMemoryRepository();
    }
}