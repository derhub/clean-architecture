<?php

namespace Derhub\Business\Services\Onboard;

use Derhub\Business\Model\Business;
use Derhub\Business\Model\BusinessRepository;
use Derhub\Business\Model\Specification\UniqueNameSpec;
use Derhub\Business\Model\Specification\UniqueSlugSpec;
use Derhub\Business\Model\Values\Country;
use Derhub\Business\Model\Values\Name;
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

    public function __invoke(OnBoardBusiness $cmd): OnBoardBusinessResponse
    {
        $response = new OnBoardBusinessResponse(null);

        try {
            $id = $this->repo->getNextId();
            $response->setAggregateRootId($id->toString());

            //TODO: check if id exist here?

            $model = new Business($id);
            $model
                ->changeName(
                    $this->uniqueNameSpec,
                    Name::fromString($cmd->name()),
                )
                ->changeSlug(
                    $this->uniqueSlugSpec,
                    Slug::fromString($cmd->slug()),
                )
                ->changeCountry(
                    Country::fromString($cmd->country()),
                )
                ->transferOwnership(OwnerId::fromString($cmd->ownerId()))
                ->onBoard()
            ;
            $this->repo->save($model);
        } catch (DomainException $e) {
            $response->addErrorFromException($e);
        }


        return $response;
    }
}
