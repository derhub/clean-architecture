<?php

namespace Tests\BusinessManagement\Business\Services;

use Derhub\BusinessManagement\Business\Infrastructure\Database\InMemoryBusinessRepository;
use Derhub\BusinessManagement\Business\Infrastructure\Database\QueryBusinessRepository;
use Derhub\BusinessManagement\Business\Model\Specification\UniqueNameSpec;
use Derhub\BusinessManagement\Business\Model\Specification\UniqueSlugSpec;
use Derhub\BusinessManagement\Business\Model\Values\BusinessId;
use Derhub\BusinessManagement\Business\Module;
use Derhub\BusinessManagement\Business\Services\BusinessQueryItem;
use Derhub\Integration\TestUtils\MessageTestCase;
use Derhub\Shared\ModuleInterface;
use Tests\BusinessManagement\Business\Fixtures\Services\BusinessQueryItemMapper;
use Tests\BusinessManagement\Business\Fixtures\Services\QueryRepositoryStub;

abstract class BaseServiceTestCase extends MessageTestCase
{
    protected BusinessId $lastId;
    protected \PHPUnit\Framework\MockObject\MockObject|UniqueNameSpec $mockUniqueNameSpec;
    protected UniqueSlugSpec|\PHPUnit\Framework\MockObject\MockObject $mockUniqueSlugSpec;
    protected BusinessQueryItemMapper $queryMapper;
    protected QueryBusinessRepository|QueryRepositoryStub $queryRepo;

    public function createQueryItemObject(): BusinessQueryItem
    {
        return new BusinessQueryItem(
            'test',
            'test',
            'test',
            'test',
            'test',
            'test',
            'test',
            'test',
            'test',
        );
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->createId();
        $this->mockUniqueNameSpec = $this->createMock(UniqueNameSpec::class);
        $this->mockUniqueSlugSpec = $this->createMock(UniqueSlugSpec::class);

        $this->queryMapper = new BusinessQueryItemMapper();
        $this->queryRepo = new QueryRepositoryStub();

        $handler = $this->getHandler();
        $this->container->add(
            $handler::class,
            static fn () => $handler,
        );
    }

    protected function createId(): BusinessId
    {
        return $this->lastId = BusinessId::generate();
    }

    abstract protected function getHandler(): object;

    protected function getModule(): ModuleInterface
    {
        return new Module();
    }

    protected function getRepository(): InMemoryBusinessRepository
    {
        return new InMemoryBusinessRepository();
    }
}
