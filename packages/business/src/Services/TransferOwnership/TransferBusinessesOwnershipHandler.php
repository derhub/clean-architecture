<?php

declare(strict_types=1);

namespace Derhub\Business\Services\TransferOwnership;

use Derhub\Business\Model\Business;
use Derhub\Business\Model\BusinessRepository;
use Derhub\Business\Model\Values\BusinessId;
use Derhub\Business\Model\Values\OwnerId;
use Derhub\Business\Services\Exception\BusinessNotFound;
use Derhub\Shared\Exceptions\ApplicationException;
use Derhub\Shared\Exceptions\DomainException;

final class TransferBusinessesOwnershipHandler
{
    public function __construct(
        private BusinessRepository $repo
    ) {
    }

    public function __invoke(
        TransferBusinessesOwnership $msg
    ): TransferBusinessesOwnershipResponse {
        $res = new TransferBusinessesOwnershipResponse($msg->aggregateRootId());
        try {
            $id = BusinessId::fromString($msg->aggregateRootId());
            /** @var \Derhub\Business\Model\Business $model */
            $model = $this->repo->get($id);

            $model->transferOwnership(OwnerId::fromString($msg->ownerId()));
            $this->repo->save($model);
        } catch (DomainException | ApplicationException $e) {
            $res->addErrorFromException($e);
        }

        return $res;
    }
}
