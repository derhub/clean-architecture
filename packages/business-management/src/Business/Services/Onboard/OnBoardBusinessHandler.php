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
use Derhub\Shared\Exceptions\DomainException;

final class OnBoardBusinessHandler
{
    public function __construct(
        private BusinessRepository $repo,
        private UniqueNameSpec $uniqueNameSpec,
        private UniqueSlugSpec $uniqueSlugSpec,
    ) {
    }

    public function __invoke(
        OnBoardBusiness $message
    ): OnBoardBusinessResponse {
        $response = new OnBoardBusinessResponse(null);

        try {
            $id = $this->repo->getNextId();
            $response->setAggregateRootId($id->toString());

            $model = new Business();

            $model->onBoard(
                $this->uniqueNameSpec,
                $this->uniqueSlugSpec,
                id: $id,
                ownerId: OwnerId::fromString($message->ownerId()),
                name: Name::fromString($message->name()),
                slug: Slug::fromString($message->slug()),
                country: Country::fromString($message->country()),
                boardingStatus:
                OnBoardStatus::fromString($message->onboardStatus()),
            );
            $this->repo->save($model);
        } catch (DomainException $e) {
            $response->addErrorFromException($e);
        }


        return $response;
    }
}
