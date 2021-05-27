<?php

namespace Derhub\Business\Services;

use Derhub\Business\Shared\SharedValues;

final class BusinessItemMapperImpl implements BusinessQueryItemMapper
{
    public function fromArray(array $data): BusinessQueryItem
    {
        return new BusinessQueryItem(
            aggregateRootId: $data[SharedValues::COL_ID]->toString(),
            ownerId: $data[SharedValues::COL_OWNER_ID]->toString(),
            slug: $data[SharedValues::COL_SLUG]->toString(),
            country: $data[SharedValues::COL_COUNTRY]->toString(),
            name: $data[SharedValues::COL_NAME]->toString(),
            status: $data[SharedValues::COL_STATUS]->toString(),
            onBoardStatus: $data[SharedValues::COL_ONBOARD_STATUS]->toString(),
            createdAt: $data[SharedValues::COL_CREATED_AT]->toString(),
            updatedAt: $data[SharedValues::COL_UPDATED_AT]->toString(),
        );
    }
}
