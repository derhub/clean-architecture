<?php

declare(strict_types=1);

namespace Derhub\BusinessManagement\Business\Model;

use Derhub\BusinessManagement\Business\Model\Event\BusinessCountryChanged;
use Derhub\BusinessManagement\Business\Model\Event\BusinessDisabled;
use Derhub\BusinessManagement\Business\Model\Event\BusinessNameChanged;
use Derhub\BusinessManagement\Business\Model\Event\BusinessOnboarded;
use Derhub\BusinessManagement\Business\Model\Event\BusinessEnabled;
use Derhub\BusinessManagement\Business\Model\Event\BusinessOwnershipTransferred;
use Derhub\BusinessManagement\Business\Model\Event\BusinessSlugChanged;

use Derhub\BusinessManagement\Business\Model\Exception\AlreadyOnBoardException;
use Derhub\BusinessManagement\Business\Model\Exception\ChangesToDisabledBusinessException;
use Derhub\BusinessManagement\Business\Model\Exception\InvalidOwnerIdException;

use Derhub\BusinessManagement\Business\Model\Exception\NameAlreadyExist;
use Derhub\BusinessManagement\Business\Model\Exception\SlugAlreadyExist;
use Derhub\BusinessManagement\Business\Model\Specification\UniqueName;
use Derhub\BusinessManagement\Business\Model\Specification\UniqueNameSpec;
use Derhub\BusinessManagement\Business\Model\Specification\UniqueSlug;
use Derhub\BusinessManagement\Business\Model\Specification\UniqueSlugSpec;
use Derhub\BusinessManagement\Business\Model\Values\Country;
use Derhub\BusinessManagement\Business\Model\Values\OnBoardStatus;
use Derhub\BusinessManagement\Business\Model\Values\Slug;
use Derhub\BusinessManagement\Business\Model\Values\Status;
use Derhub\Shared\Model\AggregateRoot;
use Derhub\Shared\Model\DomainEvent;
use Derhub\Shared\Model\UseAggregateRoot;

use Derhub\BusinessManagement\Business\Model\Values\BusinessId;
use Derhub\BusinessManagement\Business\Model\Values\Name;
use Derhub\BusinessManagement\Business\Model\Values\OwnerId;
use Derhub\Shared\Model\UseTimestampsWithSoftDelete;
use Derhub\Shared\Values\DateTimeLiteral;

/**
 * @template-implements AggregateRoot<BusinessId>
 */
final class Business implements AggregateRoot
{
    use UseAggregateRoot {
        UseAggregateRoot::record as private recordEvent;
    }
    use UseTimestampsWithSoftDelete;

    private BusinessId $aggregateRootId;

    private BusinessInfo $info;
    private OnBoardStatus $onBoardStatus;
    private Slug $slug;

    public function __construct(?BusinessId $aggregateRootId = null)
    {
        $this->aggregateRootId = $aggregateRootId ?? new BusinessId();
        $this->info = new BusinessInfo();
        $this->onBoardStatus = new OnBoardStatus();
        $this->slug = new Slug();

        $this->initTimestamps();
    }

    /**
     * @throws \Derhub\BusinessManagement\Business\Model\Exception\ChangesToDisabledBusinessException
     */
    private function disallowChangesWhenDisabled(DomainEvent $e): void
    {
        if ($e instanceof BusinessEnabled) {
            return;
        }

        if ($this->info->status()->isDisabled()) {
            throw ChangesToDisabledBusinessException::notAllowed();
        }
    }

    public function aggregateRootId(): BusinessId
    {
        return $this->aggregateRootId;
    }

    public function changeCountry(
        \Derhub\BusinessManagement\Business\Model\Values\Country $country
    ): self {
        $this->info = $this->info->newCountry($country);
        $this->record(
            new BusinessCountryChanged(
                $this->aggregateRootId()->toString(),
                $country->toString(),
            ),
        );

        return $this;
    }

    /**
     * @throws \Derhub\BusinessManagement\Business\Model\Exception\NameAlreadyExist
     * @throws \Derhub\BusinessManagement\Business\Model\Exception\ChangesToDisabledBusinessException
     */
    public function changeName(UniqueNameSpec $uniqueName, Name $name): self
    {
        $isNameUnique = $uniqueName->isSatisfiedBy(new UniqueName($name));
        if (! $isNameUnique) {
            throw NameAlreadyExist::withName($name);
        }

        $this->info = $this->info->newName($name);
        $this->record(
            new BusinessNameChanged(
                $this->aggregateRootId->toString(),
                $name->toString()
            )
        );

        return $this;
    }

    /**
     * @throws \Derhub\BusinessManagement\Business\Model\Exception\ChangesToDisabledBusinessException
     * @throws \Derhub\BusinessManagement\Business\Model\Exception\SlugAlreadyExist
     */
    public function changeSlug(
        UniqueSlugSpec $slugSpec,
        Slug $slug
    ): self {
        $isValid = $slugSpec->isSatisfiedBy(new UniqueSlug($slug));
        if (! $isValid) {
            throw SlugAlreadyExist::fromSlug($slug);
        }

        $this->slug = $slug;

        $this->record(
            new BusinessSlugChanged(
                $this->aggregateRootId()->toString(),
                $slug->toString()
            ),
        );

        return $this;
    }

    /**
     * @throws \Derhub\BusinessManagement\Business\Model\Exception\ChangesToDisabledBusinessException
     */
    public function disable(): self
    {
        $this->record(
            new BusinessDisabled($this->aggregateRootId()->toString()),
        );

        $this->info = $this->info->newStatus(Status::disable());

        return $this;
    }

    public function enable(): self
    {
        $this->record(
            new BusinessEnabled($this->aggregateRootId()->toString()),
        );

        $this->info = $this->info->newStatus(Status::enable());


        return $this;
    }

    /**
     * @throws \Derhub\BusinessManagement\Business\Model\Exception\AlreadyOnBoardException
     * @throws \Derhub\BusinessManagement\Business\Model\Exception\SlugAlreadyExist
     * @throws \Derhub\BusinessManagement\Business\Model\Exception\NameAlreadyExist
     * @throws \Derhub\BusinessManagement\Business\Model\Exception\ChangesToDisabledBusinessException
     */
    public function onBoard(
        UniqueNameSpec $nameSpec,
        UniqueSlugSpec $slugSpec,
        BusinessId $id,
        OwnerId $ownerId,
        Name $name,
        Slug $slug,
        Country $country,
    ): self {
        if ($this->onBoardStatus->toInt() > 0) {
            throw AlreadyOnBoardException::fromOnboardStatus(
                $this->onBoardStatus
            );
        }

        $checkName = $nameSpec->isSatisfiedBy(new UniqueName($name));
        if (! $checkName) {
            throw NameAlreadyExist::withName($name);
        }

        $checkSlug = $slugSpec->isSatisfiedBy(new UniqueSlug($slug));
        if (! $checkSlug) {
            throw SlugAlreadyExist::fromSlug($slug);
        }

        $this->aggregateRootId = $id;
        $this->info = $this->info
            ->newName($name)
            ->newOwner($ownerId)
            ->newCountry($country)
        ;
        $this->slug = $slug;
        $this->onBoardStatus = OnBoardStatus::start();
        $this->createdAt = DateTimeLiteral::now();

        $this->record(
            new BusinessOnboarded(
                aggregateRootId: $this->aggregateRootId()->toString(),
                ownerId: $this->info->ownerId()->toString(),
                name: $this->info->name()->toString(),
                slug: $this->slug->toString(),
                country: $this->info->country()->toString(),
                createdAt: $this->createdAt->toString(),
            )
        );

        return $this;
    }

    /**
     * @throws \Derhub\BusinessManagement\Business\Model\Exception\InvalidOwnerIdException
     * @throws \Derhub\BusinessManagement\Business\Model\Exception\ChangesToDisabledBusinessException
     */
    public function transferOwnership(OwnerId $ownerId): self
    {
        if ($ownerId->isEmpty()) {
            throw InvalidOwnerIdException::fromOnboard();
        }

        $this->info = $this->info->newOwner($ownerId);

        $this->record(
            new BusinessOwnershipTransferred(
                $this->aggregateRootId()->toString(),
                $ownerId->toString(),
            ),
        );

        return $this;
    }

    /**
     * @throws \Derhub\BusinessManagement\Business\Model\Exception\ChangesToDisabledBusinessException
     */
    protected function record(DomainEvent $e): void
    {
        $this->disallowChangesWhenDisabled($e);

        $this->recordEvent($e);
    }
}
