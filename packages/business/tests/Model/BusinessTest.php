<?php

namespace Tests\Business\Model;

use Derhub\Business\Infrastructure\Database\InMemoryBusinessRepository;
use Derhub\Business\Model\Entity\BusinessInfo;
use Derhub\Business\Model\Event\BusinessCountryChanged;
use Derhub\Business\Model\Event\BusinessEnabled;
use Derhub\Business\Model\Event\BusinessNameChanged;
use Derhub\Business\Model\Event\BusinessOwnershipTransferred;
use Derhub\Business\Model\Event\BusinessSlugChanged;
use Derhub\Business\Model\Exception\EmptyOwnerIdException;
use Derhub\Business\Model\Exception\NameAlreadyExist;
use Derhub\Business\Model\Exception\SlugExistException;
use Derhub\Business\Model\Specification\UniqueSlugSpec;
use Derhub\Business\Model\Values\Country;
use Derhub\Business\Model\Values\OnBoardStatus;
use Derhub\Business\Model\Values\OwnerId;
use Derhub\Business\Model\Values\Slug;

use Derhub\Business\Model\Event\BusinessDisabled;
use Derhub\Business\Model\Business;
use Derhub\Business\Model\Event\BusinessHanded;
use Derhub\Business\Model\Event\BusinessOnboarded;
use Derhub\Business\Model\Specification\UniqueNameSpec;
use Derhub\Business\Model\Values\BusinessId;
use Derhub\Business\Model\Values\Name;
use Derhub\Business\Model\Values\Status;
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
    private const INFO = 'info';
    private const SLUG = 'slug';

    protected function setUp(): void
    {
        parent::setUp();
        DateTimeLiteral::freezeAt(DateTimeLiteral::now());
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

        $this->checkObjectPropertyValues(
            $model,
            [
                self::INFO => (new BusinessInfo())->newOwner($ownerId),
            ],
        );

        $this->expectException(EmptyOwnerIdException::class);
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
        $this->checkObjectPropertyValues(
            $model,
            [
                self::SLUG => $slug,
            ],
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
        $this->checkObjectPropertyValues(
            $model,
            [
                self::INFO => (new BusinessInfo())->newName($name),
            ],
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
        $model->changeSlug(
            IsUniqueSlug::yes(),
            Slug::fromString('testdddd'),
        );
        $model->changeName(
            IsUniqueName::yes(),
            Name::fromString('test 1'),
        );
        $model->transferOwnership($ownerId);
        $model->changeCountry(Country::fromAlpha2('PH'));
        $model->pullEvents();

        $model->onBoard();
        $this->assertEvents(
            [
                BusinessOnboarded::class,
            ],
            $model->pullEvents(),
        );

        $this->checkObjectPropertyValues(
            $model,
            [
                'onBoardStatus' => OnBoardStatus::onBoard(),
                'status' => Status::enable(),
                'createdAt' => DateTimeLiteral::now(),
            ]
        );
    }

    public function test_hand_over(): void
    {
        $ownerId = OwnerId::fromString(Uuid::generate());

        $model = $this->createModel();
        $model->changeSlug(
            IsUniqueSlug::yes(),
            Slug::fromString('testdddd'),
        );
        $model->changeName(
            IsUniqueName::yes(),
            Name::fromString('test 1'),
        );
        $model->transferOwnership($ownerId);
        $model->changeCountry(Country::fromString('PH'));
        $model->pullEvents();

        $model->handOver();
        $this->assertEvents(
            [
                BusinessHanded::class,
            ],
            $model->pullEvents(),
        );

        $this->checkObjectPropertyValues(
            $model,
            [
                'onBoardStatus' => OnBoardStatus::handed(),
                'status' => Status::enable(),
            ]
        );
    }

    private function createModel(): Business
    {
        $id = BusinessId::fromString((string)Uuid::generate());
        return new Business(aggregateRootId: $id);
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
            [BusinessCountryChanged::class], $model->pullEvents()
        );

        $this->checkObjectPropertyValues(
            $model,
            [
                'info' => (new BusinessInfo())->newCountry($country),
            ]
        );
    }
}
