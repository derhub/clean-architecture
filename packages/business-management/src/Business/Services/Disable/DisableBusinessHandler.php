<?php

namespace Derhub\BusinessManagement\Business\Services\Disable;

use Derhub\BusinessManagement\Business\Model\BusinessRepository;
use Derhub\BusinessManagement\Business\Model\Values\BusinessId;
use Derhub\BusinessManagement\Business\Services\CommandResponse;

final class DisableBusinessHandler
{
    public function __construct(
        private BusinessRepository $repo
    ) {
    }

    public function __invoke(DisableBusiness $msg): CommandResponse
    {
        $id = BusinessId::fromString($msg->aggregateRootId());

        /** @var \Derhub\BusinessManagement\Business\Model\Business $model */
        $model = $this->repo->get($id);

        $model->disable();

        $this->repo->save($model);

        return new CommandResponse($msg->aggregateRootId());
    }
}
