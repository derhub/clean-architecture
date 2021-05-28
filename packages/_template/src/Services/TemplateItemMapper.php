<?php

namespace EB\Template\Services;

use EB\Template\Shared\SharedValues;

class TemplateItemMapper
{
    public function fromArray(array $data): array
    {
        return [
            'id' => $data[SharedValues::COL_ID],
        ];
    }
}