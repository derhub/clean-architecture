<?php

declare(strict_types=1);

namespace Derhub\BusinessManagement\Business\Services\TransferOwnership;

use Derhub\BusinessManagement\Business\Model\BusinessRepository;
use Derhub\BusinessManagement\Business\Model\Values\BusinessId;
use Derhub\BusinessManagement\Business\Model\Values\OwnerId;
use Derhub\BusinessManagement\Business\Services\CommandResponse;

final class TransferBusinessOwnershipHandler
{
    public function __construct(
        private BusinessRepository $repo
    ) {
    }

    /**
     * @throws \Derhub\BusinessManagement\Business\Model\Exception\InvalidOwnerIdException
     * @throws \Derhub\BusinessManagement\Business\Model\Exception\ChangesToDisabledBusinessException
     */
    public function __invoke(
        TransferBusinessOwnership $msg
    ): CommandResponse {
        $id = BusinessId::fromString($msg->aggregateRootId());
        /** @var \Derhub\BusinessManagement\Business\Model\Business $model */
        $model = $this->repo->get($id);

        $model->transferOwnership(OwnerId::fromString($msg->ownerId()));
        $this->repo->save($model);

        return new CommandResponse($msg->aggregateRootId());
    }
}
