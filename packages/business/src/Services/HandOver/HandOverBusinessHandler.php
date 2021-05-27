<?php

namespace Derhub\Business\Services\HandOver;

use Derhub\Business\Model\Business;
use Derhub\Business\Model\Values\BusinessId;
use Derhub\Business\Model\Values\OwnerId;
use Derhub\Business\Services\Exception\BusinessNotFound;
use Derhub\Business\Model\BusinessRepository;
use Derhub\Shared\Exceptions\ApplicationException;
use Derhub\Shared\Exceptions\DomainException;

final class HandOverBusinessHandler
{
    public function __construct(private BusinessRepository $repo)
    {
    }

    public function __invoke(HandOverBusiness $msg): HandOverBusinessResponse
    {
        $res = new HandOverBusinessResponse($msg->aggregateRootId());
        try {
            $id = BusinessId::fromString($msg->aggregateRootId());
            $model = $this->getModel($id);
            $model->handOver();
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
