<?php

namespace Derhub\Business\Services\Onboard;

use Derhub\Business\Model\Business;
use Derhub\Business\Model\BusinessRepository;
use Derhub\Business\Model\Specification\UniqueNameSpec;
use Derhub\Business\Model\Specification\UniqueSlugSpec;
use Derhub\Business\Model\Values\Country;
use Derhub\Business\Model\Values\Name;
use Derhub\Business\Model\Values\OnBoardStatus;
use Derhub\Business\Model\Values\OwnerId;
use Derhub\Business\Model\Values\Slug;
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
