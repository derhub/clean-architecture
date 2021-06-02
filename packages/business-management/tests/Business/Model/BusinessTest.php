<?php

namespace Tests\BusinessManagement\Business\Model;

use Derhub\BusinessManagement\Business\Infrastructure\Database\InMemoryBusinessRepository;
use Derhub\BusinessManagement\Business\Model\Event\BusinessCountryChanged;
use Derhub\BusinessManagement\Business\Model\Event\BusinessEnabled;
use Derhub\BusinessManagement\Business\Model\Event\BusinessNameChanged;
use Derhub\BusinessManagement\Business\Model\Event\BusinessOwnershipTransferred;
use Derhub\BusinessManagement\Business\Model\Event\BusinessSlugChanged;
use Derhub\BusinessManagement\Business\Model\Exception\InvalidOwnerIdException;
use Derhub\BusinessManagement\Business\Model\Exception\NameAlreadyExist;
use Derhub\BusinessManagement\Business\Model\Exception\SlugExistException;
use Derhub\BusinessManagement\Business\Model\Specification\UniqueSlugSpec;
use Derhub\BusinessManagement\Business\Model\Values\Country;
use Derhub\BusinessManagement\Business\Model\Values\OnBoardStatus;
use Derhub\BusinessManagement\Business\Model\Values\OwnerId;
use Derhub\BusinessManagement\Business\Model\Values\Slug;

use Derhub\BusinessManagement\Business\Model\Event\BusinessDisabled;
use Derhub\BusinessManagement\Business\Model\Business;
use Derhub\BusinessManagement\Business\Model\Event\BusinessOnboarded;
use Derhub\BusinessManagement\Business\Model\Specification\UniqueNameSpec;
use Derhub\BusinessManagement\Business\Model\Values\BusinessId;
use Derhub\BusinessManagement\Business\Model\Values\Name;
use Derhub\Integration\TestUtils\ModuleTestCase;
use Derhub\Shared\Infrastructure\FakeSpecification\FakeSpecification;
use Derhub\Shared\Model\DomainEvent;
use Derhub\Shared\Utils\Uuid;
use Derhub\Shared\Values\DateTimeLiteral;

class IsUniqueName extends FakeSpecification implements UniqueNameSpec
{
}


class IsUniqueSlug extends FakeSpecification implements UniqueSlugSpec
{
}

class BusinessTest extends ModuleTestCase
{
    private BusinessId $lastId;

    protected function setUp(): void
    {
        parent::setUp();
        DateTimeLiteral::freezeAt(DateTimeLiteral::now());
        $this->lastId = BusinessId::generate();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        DateTimeLiteral::unFreeze();
    }

    protected function givenRepository(): InMemoryBusinessRepository
    {
        return new InMemoryBusinessRepository();
    }

    public function test_transfer_ownership(): void
    {
        $ownerId = OwnerId::generate();

        $model = $this->createModel();
        $model->transferOwnership($ownerId);
        $this->assertEvents(
            [BusinessOwnershipTransferred::class],
            $model->pullEvents()
        );


        $this->expectException(InvalidOwnerIdException::class);
        $model->transferOwnership(new OwnerId());
    }

    public function test_change_slug(): void
    {
        $slug = Slug::fromString('test-c-f95jfgjas');
        $model = $this->createModel();
        $model->changeSlug(
            IsUniqueSlug::yes(),
            $slug
        );

        $this->assertEvents([BusinessSlugChanged::class], $model->pullEvents());

        $this->expectException(SlugExistException::class);
        $model = $this->createModel();
        $model->changeSlug(
            IsUniqueSlug::no(),
            $slug
        );
    }

    public function test_change_name(): void
    {
        $name = Name::fromString('test-c-f95jfgjas');
        $model = $this->createModel();
        $model->changeName(
            IsUniqueName::yes(),
            $name
        );

        $this->assertEvents([BusinessNameChanged::class], $model->pullEvents());

        $this->expectException(NameAlreadyExist::class);
        $model = $this->createModel();
        $model->changeName(
            IsUniqueName::no(),
            $name
        );
    }

    public function test_on_board(): void
    {
        $ownerId = OwnerId::fromString(Uuid::generate());

        $model = $this->createModel();

        $model->onBoard(
            nameSpec: IsUniqueName::yes(),
            slugSpec: IsUniqueSlug::yes(),
            id: $this->lastId,
            ownerId: $ownerId,
            name: Name::fromString('test 1'),
            slug: Slug::fromString('test-2-s-f-g'),
            country: Country::fromAlpha2('PH'),
            boardingStatus: OnBoardStatus::byOwner(),
        );
        $this->assertEvents(
            [
                BusinessOnboarded::class,
            ],
            $model->pullEvents(),
        );
    }

    private function createModel(): Business
    {
        $this->lastId = BusinessId::fromString((string)Uuid::generate());
        return new Business($this->lastId);
    }

    public function test_disabled(): void
    {
        $model = $this->createModel();
        $model->disable();
        $this->assertEvents([BusinessDisabled::class], $model->pullEvents());
    }

    public function test_enabled(): void
    {
        $model = $this->createModel();
        $model->enable();
        $this->assertEvents([BusinessEnabled::class], $model->pullEvents());
    }

    /**
     * @param array<class-string> $actual
     * @param \Derhub\Shared\Model\DomainEvent[] $events
     */
    private function assertEvents(array $actual, array $events): void
    {
        $classStringEvents =
            array_map(static fn (DomainEvent $e) => $e::class, $events);
        self::assertEquals($actual, $classStringEvents);
    }

    public function test_change_country(): void
    {
        $country = Country::fromString('DK');
        $model = $this->createModel();
        $model->changeCountry($country);
        $this->assertEvents(
            [BusinessCountryChanged::class],
            $model->pullEvents()
        );
    }
}
