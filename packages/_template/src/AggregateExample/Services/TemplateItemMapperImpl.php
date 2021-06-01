<?php

namespace Derhub\Template\AggregateExample\Services;

final class TemplateItemMapperImpl implements TemplateQueryItemMapper
{
    public function fromArray(array $data): TemplateQueryItem
    {
        return new TemplateQueryItem(
            aggregateRootId: $data['aggregateRootId']->toString(),
            name: $data['name']->toString(),
            status: $data['status']->toString(),
            createdAt: $data['createdAt']->toString(),
            updatedAt: $data['updatedAt']->toString(),
            deletedAt: $data['deletedAt']->toString(),
        );
    }
}
