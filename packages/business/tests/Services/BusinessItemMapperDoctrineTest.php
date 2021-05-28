<?php

namespace Tests\Business\Services;

use Derhub\Business\Model\Values\BusinessId;
use Derhub\Business\Model\Values\Country;
use Derhub\Business\Model\Values\Name;
use Derhub\Business\Model\Values\OnBoardStatus;
use Derhub\Business\Model\Values\OwnerId;
use Derhub\Business\Model\Values\Slug;
use Derhub\Business\Model\Values\Status;
use Derhub\Business\Services\BusinessItemMapperDoctrine;
use Derhub\Business\Services\BusinessQueryItem;
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
                'status' => Status::enable(),
                'onBoardStatus' => OnBoardStatus::byOwner(),
                'createdAt' => DateTimeLiteral::now(),
                'updatedAt' => DateTimeLiteral::now(),
            ]
        );
        self::assertEquals($id->toString(), $data->aggregateRootId());
    }
}
