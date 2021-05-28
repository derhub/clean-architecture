<?php

declare(strict_types=1);

namespace EB\Template\Model\Specification;

use EB\Template\Model\ValueObject\TemplateId;

class UniqueSample
{
    public function __construct(private TemplateId $aggregateRootId)
    {
    }

    public function aggregateRootId(): TemplateId
    {
        return $this->aggregateRootId;
    }

}