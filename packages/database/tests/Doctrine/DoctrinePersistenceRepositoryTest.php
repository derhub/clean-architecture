<?php

namespace Tests\Database\Doctrine;

use Derhub\Shared\Database\Doctrine\DoctrinePersistenceRepository;
use Derhub\Shared\Database\Doctrine\MissingAggregateClassNameException;
use Derhub\Shared\Database\Exceptions\AggregateNotFound;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;
use Tests\Database\Fixtures\AggregateRootFixture;
use Tests\Database\Fixtures\AggregateRootIdFixture;

class DoctrinePersistenceRepositoryTest extends TestCase
{
    /**
     * @var \Derhub\Shared\Database\Doctrine\DoctrinePersistenceRepository
     */
    private DoctrinePersistenceRepository $repo;
    /**
     * @var \Doctrine\ORM\EntityManagerInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private EntityManagerInterface|\PHPUnit\Framework\MockObject\MockObject $entityMock;
    /**
     * @var \Doctrine\ORM\EntityRepository|\PHPUnit\Framework\MockObject\MockObject
     */
    private ObjectRepository|\PHPUnit\Framework\MockObject\MockObject $repoMock;

    public function setUp(): void
    {
        parent::setUp();

        $this->entityMock = $this->createMock(EntityManagerInterface::class);
        $this->repoMock = $this->createMock(EntityRepository::class);
        $this->entityMock->expects(self::any())
            ->method('getRepository')
            ->willReturn($this->repoMock)
        ;

        $this->repo = new DoctrinePersistenceRepository($this->entityMock);
    }

    /**
     * @test
     */
    public function it_fails_when_class_name_is_missing(): void
    {
        $this->expectException(MissingAggregateClassNameException::class);
        $this->repo->findById('test');
    }

    /**
     * @test
     */
    public function it_throw_exception_when_entity_not_found(): void
    {
        $this->expectException(AggregateNotFound::class);
        $this->repo->setAggregateClass(AggregateRootFixture::class);
        $this->repo->findById('test');
    }

    /**
     * @test
     */
    public function it_can_find_by_id(): void
    {
        $this->repo->setAggregateClass(AggregateRootFixture::class);

        $model = new AggregateRootFixture(AggregateRootIdFixture::generate());

        $this->repoMock->expects(self::any())
            ->method('find')
            ->willReturn($model)
        ;
        $result = $this->repo->findById('test');
        self::assertEquals($model, $result);
    }

    /**
     * @test
     */
    public function it_persist_aggregate_object(): void
    {
        $this->repo->setAggregateClass(AggregateRootFixture::class);

        $model = new AggregateRootFixture(AggregateRootIdFixture::generate());

        $this->entityMock->expects(self::atLeast(1))
            ->method('persist')
        ;

        $this->entityMock->expects(self::atLeast(1))
            ->method('flush')
        ;

        $this->repo->persist($model);
    }

}
