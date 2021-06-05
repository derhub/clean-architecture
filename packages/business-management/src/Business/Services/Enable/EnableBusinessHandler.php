<?php

namespace Derhub\BusinessManagement\Business\Services\Enable;

use Derhub\BusinessManagement\Business\Model\Business;
use Derhub\BusinessManagement\Business\Model\BusinessRepository;
use Derhub\BusinessManagement\Business\Model\Values\BusinessId;
use Derhub\BusinessManagement\Business\Services\CommandResponse;
use Derhub\Shared\Exceptions\ApplicationException;
use Derhub\Shared\Exceptions\DomainException;

class EnableBusinessHandler
{
    public function __construct(private BusinessRepository $repo)
    {
    }

    public function __invoke(EnableBusiness $msg): CommandResponse
    {
        $id = BusinessId::fromString($msg->aggregateRootId());

        $model = $this->getModel($id);

        $model->enable();

        $this->repo->save($model);

        return new CommandResponse($msg->aggregateRootId());
    }

    private function getModel(BusinessId $id): Business
    {
        /** @var ?\Derhub\BusinessManagement\Business\Model\Business $model */
        $model = $this->repo->get($id);

        if (! $model) {
            throw BusinessNotFound::fromId($id);
        }

        return $model;
    }
}
