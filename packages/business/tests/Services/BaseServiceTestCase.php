<?php

namespace Tests\Business\Services;

use Derhub\Business\Infrastructure\Database\InMemoryBusinessRepository;
use Derhub\Business\Infrastructure\Database\QueryBusinessRepository;
use Derhub\Business\Model\Specification\UniqueNameSpec;
use Derhub\Business\Model\Specification\UniqueSlugSpec;
use Derhub\Business\Model\Values\BusinessId;
use Derhub\Business\Module;
use Derhub\Business\Services\BusinessQueryItem;
use Derhub\Business\Services\Disable\DisableBusinessHandler;
use Derhub\Integration\TestUtils\MessageTestCase;
use Derhub\Shared\ModuleInterface;
use Tests\Business\Fixtures\Services\BusinessQueryItemMapper;
use Tests\Business\Fixtures\Services\QueryRepositoryStub;

abstract class BaseServiceTestCase extends MessageTestCase
{
    protected BusinessQueryItemMapper $queryMapper;
    protected BusinessId $lastId;
    protected QueryBusinessRepository|QueryRepositoryStub $queryRepo;
    protected \PHPUnit\Framework\MockObject\MockObject|UniqueNameSpec $mockUniqueNameSpec;
    protected UniqueSlugSpec|\PHPUnit\Framework\MockObject\MockObject $mockUniqueSlugSpec;

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

    abstract protected function getHandler(): object;

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

    protected function getModule(): ModuleInterface
    {
        return new Module();
    }

    protected function createId(): BusinessId
    {
        return $this->lastId = BusinessId::generate();
    }

    protected function getRepository(): InMemoryBusinessRepository
    {
        return new InMemoryBusinessRepository();
    }
}