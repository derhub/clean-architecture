<?php

namespace Tests\BusinessManagement\Business\Services\TransferOwnership;

use Derhub\BusinessManagement\Business\Model\Business;
use Derhub\BusinessManagement\Business\Model\Values\OwnerId;
use Derhub\BusinessManagement\Business\Services\TransferOwnership\TransferBusinessesOwnership;
use Derhub\BusinessManagement\Business\Services\TransferOwnership\TransferBusinessesOwnershipHandler;
use Derhub\Shared\Message\Command\CommandResponse;
use Tests\BusinessManagement\Business\Services\BaseServiceTestCase;

class TransferBusinessesOwnershipTest extends BaseServiceTestCase
{
    protected function getHandler(): object
    {
        return new TransferBusinessesOwnershipHandler($this->repository);
    }

    /**
     * @test
     */
    public function it_change_owner(): void
    {
        $this->givenExisting(Business::class)
            ->when(
                new TransferBusinessesOwnership(
                    $this->lastId->toString(),
                    OwnerId::generate()->toString()
                )
            )->then(CommandResponse::class)
        ;
    }
}
