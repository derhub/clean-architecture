<?php

namespace Derhub\Template\Services;

final class BusinessItemMapperDoctrine implements BusinessQueryItemMapper
{
    public function fromArray(array $data): BusinessQueryItem
    {
        return new BusinessQueryItem(
            aggregateRootId: $data['aggregateRootId']->toString(),
            name: $data['name']->toString(),
            createdAt: $data['createdAt']->toString(),
            updatedAt: $data['updatedAt']->toString(),
            deletedAt: $data['deletedAt']->toString(),
        );
    }
}
