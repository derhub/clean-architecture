<?php

namespace Derhub\BusinessManagement\Business\Services\Onboard;

use Derhub\BusinessManagement\Business\Model\Business;
use Derhub\BusinessManagement\Business\Model\BusinessRepository;
use Derhub\BusinessManagement\Business\Model\Specification\UniqueNameSpec;
use Derhub\BusinessManagement\Business\Model\Specification\UniqueSlugSpec;
use Derhub\BusinessManagement\Business\Model\Values\Country;
use Derhub\BusinessManagement\Business\Model\Values\Name;
use Derhub\BusinessManagement\Business\Model\Values\OnBoardStatus;
use Derhub\BusinessManagement\Business\Model\Values\OwnerId;
use Derhub\BusinessManagement\Business\Model\Values\Slug;
use Derhub\BusinessManagement\Business\Services\CommandResponse;
use Derhub\Shared\Exceptions\DomainException;

final class OnBoardBusinessHandler
{
    public function __construct(
        private BusinessRepository $repo,
        private UniqueNameSpec $uniqueNameSpec,
        private UniqueSlugSpec $uniqueSlugSpec,
    ) {
    }

    /**
     * @throws \Derhub\BusinessManagement\Business\Model\Exception\InvalidOwnerIdException
     * @throws \Derhub\BusinessManagement\Business\Model\Exception\AlreadyOnBoardException
     * @throws \Derhub\BusinessManagement\Business\Model\Exception\SlugAlreadyExist
     * @throws \Derhub\BusinessManagement\Business\Model\Exception\NameAlreadyExist
     * @throws \Derhub\BusinessManagement\Business\Model\Exception\ChangesToDisabledBusinessException
     */
    public function __invoke(
        OnBoardBusiness $message
    ): \Derhub\Shared\Message\Command\CommandResponse {
        $id = $this->repo->getNextId();

        $model = new Business();

        $model->onBoard(
            $this->uniqueNameSpec,
            $this->uniqueSlugSpec,
            id: $id,
            ownerId: OwnerId::fromString($message->ownerId()),
            name: Name::fromString($message->name()),
            slug: Slug::fromString($message->slug()),
            country: Country::fromString($message->country()),
        );
        $this->repo->save($model);


        return new CommandResponse($id->toString());
    }
}
