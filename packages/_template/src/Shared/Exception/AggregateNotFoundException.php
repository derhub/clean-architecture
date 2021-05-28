<?php

namespace EB\Template\Shared\Exception;

use EB\Shared\Exceptions\LayeredException;
use EB\Template\Model\ValueObject\TemplateId;

class AggregateNotFoundException extends \Exception implements LayeredException
{
    public static function fromId(TemplateId $id): self
    {
        return new self(
            sprintf('%s not found', (string)$id)
        );
    }
}