<?php

namespace Derhub\Business\Process;

use Derhub\Business\Model\BusinessRepository;
use Derhub\Business\Model\Event\BusinessEnabled;
use Derhub\Business\Model\Values\BusinessId;
use Derhub\Business\Services\Exception\BusinessNotFound;

class BusinessEnabledReact
{
    public function __construct(private BusinessRepository $repository)
    {
    }

    public function __invoke(BusinessEnabled $message)
    {
        $aggregateId = BusinessId::fromString($message->aggregateRootId());
        $model = $this->repository->get($aggregateId);
        if (! $model) {
            throw BusinessNotFound::fromId($aggregateId);
        }

        $model->enable();
        $this->repository->save($model);
    }
}