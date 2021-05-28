<?php

declare(strict_types=1);

namespace Derhub\Business\Model;

use Derhub\Business\Model\Entity\BusinessInfo;
use Derhub\Business\Model\Event\BusinessCountryChanged;
use Derhub\Business\Model\Event\BusinessDisabled;
use Derhub\Business\Model\Event\BusinessHanded;
use Derhub\Business\Model\Event\BusinessNameChanged;
use Derhub\Business\Model\Event\BusinessOnboarded;
use Derhub\Business\Model\Event\BusinessEnabled;
use Derhub\Business\Model\Event\BusinessOwnershipTransferred;
use Derhub\Business\Model\Event\BusinessSlugChanged;

use Derhub\Business\Model\Exception\AlreadyOnBoardException;
use Derhub\Business\Model\Exception\AlreadyHandedException;
use Derhub\Business\Model\Exception\EmptyCountryException;
use Derhub\Business\Model\Exception\InvalidSlugException;
use Derhub\Business\Model\Exception\ChangesToDisabledBusinessException;
use Derhub\Business\Model\Exception\InvalidNameException;
use Derhub\Business\Model\Exception\InvalidOwnerIdException;

use Derhub\Business\Model\Exception\NameAlreadyExist;
use Derhub\Business\Model\Exception\SlugExistException;
use Derhub\Business\Model\Specification\UniqueName;
use Derhub\Business\Model\Specification\UniqueNameSpec;
use Derhub\Business\Model\Specification\UniqueSlug;
use Derhub\Business\Model\Specification\UniqueSlugSpec;
use Derhub\Business\Model\Values\Country;
use Derhub\Business\Model\Values\OnBoardStatus;
use Derhub\Business\Model\Values\Slug;
use Derhub\Business\Model\Values\Status;
use Derhub\Shared\Model\AggregateRoot;
use Derhub\Shared\Model\DomainEvent;
use Derhub\Shared\Model\UseAggregateRoot;

use Derhub\Business\Model\Values\BusinessId;
use Derhub\Business\Model\Values\Name;
use Derhub\Business\Model\Values\OwnerId;
use Derhub\Shared\Model\UseTimestampsWithSoftDelete;
use Derhub\Shared\Values\DateTimeLiteral;

/**
 * @template-implements AggregateRoot<BusinessId>
 */
final class Business implements AggregateRoot
{
    use UseTimestampsWithSoftDelete;
    use UseAggregateRoot {
        UseAggregateRoot::record as private _record;
    }

    private BusinessInfo $info;
    private Slug $slug;
    private OnBoardStatus $onBoardStatus;
    private Status $status;
    private BusinessId $aggregateRootId;

    public function __construct(?BusinessId $aggregateRootId = null)
    {
        $this->aggregateRootId = $aggregateRootId ?? new BusinessId();
        $this->info = new BusinessInfo();
        $this->onBoardStatus = new OnBoardStatus();
        $this->status = new Status();
        $this->slug = new Slug();

        $this->initTimestamps();
    }

    public function aggregateRootId(): BusinessId
    {
        return $this->aggregateRootId;
    }

    public function owner(): OwnerId
    {
        return $this->info->ownerId();
    }

    /**
     * @throws \Derhub\Business\Model\Exception\ChangesToDisabledBusinessException
     */
    protected function record(DomainEvent $e): void
    {
        $this->disallowChangesWhenDisabled($e);

        $this->_record($e);
    }

    /**
     * @throws \Derhub\Business\Model\Exception\ChangesToDisabledBusinessException
     */
    private function disallowChangesWhenDisabled(DomainEvent $e): void
    {
        if ($e instanceof BusinessEnabled) {
            return;
        }

        if ($this->status->isDisabled()) {
            throw ChangesToDisabledBusinessException::notAllowed();
        }
    }

    public function changeCountry(\Derhub\Business\Model\Values\Country $country
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

    public function onBoard(
        UniqueNameSpec $nameSpec,
        UniqueSlugSpec $slugSpec,
        BusinessId $id,
        OwnerId $ownerId,
        Name $name,
        Slug $slug,
        Country $country,
        OnBoardStatus $boardingStatus,
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
            throw SlugExistException::fromSlug($slug);
        }

        $this->aggregateRootId = $id;
        $this->info = $this->info
            ->newName($name)
            ->newOwner($ownerId)
            ->newCountry($country)
        ;
        $this->slug = $slug;
        $this->onBoardStatus = $boardingStatus;
        $this->createdAt = DateTimeLiteral::now();

        $this->record(
            new BusinessOnboarded(
                aggregateRootId: $this->aggregateRootId()->toString(),
                ownerId: $this->owner()->toString(),
                name: $this->info->name()->toString(),
                slug: $this->slug->toString(),
                country: $this->info->country()->toString(),
                boardingStatus: $this->onBoardStatus->toString(),
                createdAt: $this->createdAt->toString(),
            )
        );

        return $this;
    }

    public function disable(): self
    {
        $this->record(
            new BusinessDisabled($this->aggregateRootId()->toString()),
        );

        $this->status = Status::disable();

        return $this;
    }

    public function enable(): self
    {
        $this->record(
            new BusinessEnabled($this->aggregateRootId()->toString()),
        );

        $this->status = Status::enable();

        return $this;
    }

    public function changeSlug(
        UniqueSlugSpec $slugSpec,
        Slug $slug
    ): self {
        $isValid = $slugSpec->isSatisfiedBy(new UniqueSlug($slug));
        if (! $isValid) {
            throw SlugExistException::fromSlug($slug);
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
     * @throws \Derhub\Business\Model\Exception\InvalidOwnerIdException
     * @throws \Derhub\Business\Model\Exception\ChangesToDisabledBusinessException
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
}
