<?php

namespace Derhub\Business\Services\Enable;

use Derhub\Business\Model\Business;
use Derhub\Business\Model\BusinessRepository;
use Derhub\Business\Model\Values\BusinessId;
use Derhub\Shared\Exceptions\ApplicationException;
use Derhub\Shared\Exceptions\DomainException;

class EnableBusinessHandler
{
    public function __construct(private BusinessRepository $repo)
    {
    }

    public function __invoke(EnableBusiness $msg): EnableBusinessResponse
    {
        $res = new EnableBusinessResponse($msg->aggregateRootId());
        try {
            $id = BusinessId::fromString($msg->aggregateRootId());

            $model = $this->getModel($id);

            $model->enable();

            $this->repo->save($model);
        } catch (DomainException | ApplicationException $e) {
            $res->addErrorFromException($e);
        }

        return $res;
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
