<?php

namespace Tests\BusinessManagement\Business\Services\TransferOwnership;

use Derhub\BusinessManagement\Business\Model\Business;
use Derhub\BusinessManagement\Business\Model\Values\OwnerId;
use Derhub\BusinessManagement\Business\Services\TransferOwnership\TransferBusinessOwnership;
use Derhub\BusinessManagement\Business\Services\TransferOwnership\TransferBusinessOwnershipHandler;
use Derhub\Shared\Message\Command\CommandResponse;
use Tests\BusinessManagement\Business\Services\BaseServiceTestCase;

class TransferBusinessesOwnershipTest extends BaseServiceTestCase
{
    /**
     * @test
     */
    public function it_change_owner(): void
    {
        $this->givenExisting(Business::class)
            ->when(
                new TransferBusinessOwnership(
                    $this->lastId->toString(),
                    OwnerId::generate()->toString()
                )
            )->then(CommandResponse::class)
        ;
    }
    protected function getHandler(): object
    {
        return new TransferBusinessOwnershipHandler($this->repository);
    }
}
