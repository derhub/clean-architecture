<?php

namespace Derhub\BusinessManagement\Business\Services;

final class BusinessItemMapperDoctrine implements BusinessQueryItemMapper
{
    public function fromArray(array $data): BusinessQueryItem
    {
        return new BusinessQueryItem(
            aggregateRootId: $data['aggregateRootId']->toString(),
            ownerId: $data['info.ownerId']->toString(),
            slug: $data['slug']->toString(),
            country: $data['info.country']->toString(),
            name: $data['info.name']->toString(),
            status: $data['info.status']->toString(),
            onBoardStatus: $data['onBoardStatus']->toString(),
            createdAt: $data['createdAt']->toString(),
            updatedAt: $data['updatedAt']->toString(),
        );
    }
}
