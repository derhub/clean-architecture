<?php

namespace Tests\BusinessManagement\Business\Services;

use Derhub\BusinessManagement\Business\Model\Values\BusinessId;
use Derhub\BusinessManagement\Business\Model\Values\Country;
use Derhub\BusinessManagement\Business\Model\Values\Name;
use Derhub\BusinessManagement\Business\Model\Values\OnBoardStatus;
use Derhub\BusinessManagement\Business\Model\Values\OwnerId;
use Derhub\BusinessManagement\Business\Model\Values\Slug;
use Derhub\BusinessManagement\Business\Model\Values\Status;
use Derhub\BusinessManagement\Business\Services\BusinessItemMapperDoctrine;
use Derhub\Shared\Values\DateTimeLiteral;
use PHPUnit\Framework\TestCase;

class BusinessItemMapperDoctrineTest extends TestCase
{
    public function testFromArray(): void
    {
        $id = BusinessId::generate();
        $mapper = new BusinessItemMapperDoctrine();
        $data = $mapper->fromArray(
            [
                'aggregateRootId' => $id,
                'info.ownerId' => OwnerId::generate(),
                'slug' => Slug::fromString('test-a-a-s-d-f'),
                'info.country' => Country::fromString('PH'),
                'info.name' => Name::fromString('test'),
                'info.status' => Status::enable(),
                'onBoardStatus' => OnBoardStatus::byOwner(),
                'createdAt' => DateTimeLiteral::now(),
                'updatedAt' => DateTimeLiteral::now(),
            ]
        );
        self::assertEquals($id->toString(), $data->aggregateRootId());
    }
}
