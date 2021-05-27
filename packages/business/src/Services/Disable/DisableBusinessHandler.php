<?php

namespace Derhub\Business\Services\Disable;

use Derhub\Business\Model\Business;
use Derhub\Business\Model\BusinessRepository;
use Derhub\Business\Model\Values\BusinessId;
use Derhub\Business\Services\Exception\BusinessNotFound;
use Derhub\Shared\Exceptions\ApplicationException;
use Derhub\Shared\Exceptions\DomainException;

final class DisableBusinessHandler
{
    public function __construct(
        private BusinessRepository $repo
    ) {
    }

    public function __invoke(DisableBusiness $msg): DisableBusinessResponse
    {
        $response = new DisableBusinessResponse($msg->aggregateRootId());
        try {
            $id = BusinessId::fromString($msg->aggregateRootId());

            $model = $this->getModel($id);

            $model->disable();

            $this->repo->save($model);
        } catch (DomainException | ApplicationException $e) {
            $response->addErrorFromException($e);
        }

        return $response;
    }

    private function getModel(BusinessId $id): Business
    {
        /** @var ?\Derhub\Business\Model\Business $model */
        $model = $this->repo->get($id);

        if (! $model) {
            throw BusinessNotFound::fromId($id);
        }

        return $model;
    }
}
