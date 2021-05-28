<?php

namespace Tests\Business\Services\TransferOwnership;

use Derhub\Business\Model\Business;
use Derhub\Business\Model\Values\OwnerId;
use Derhub\Business\Services\TransferOwnership\TransferBusinessesOwnership;
use Derhub\Business\Services\TransferOwnership\TransferBusinessesOwnershipHandler;
use Derhub\Shared\Message\Command\CommandResponse;
use Tests\Business\Services\BaseServiceTestCase;

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
