<?php

namespace Derhub\Template\AggregateExample\Model;

use Derhub\Shared\Model\MultiTenantAggregateRoot;
use Derhub\Shared\Model\UseAggregateRoot;
use Derhub\Shared\Model\UseTimestampsWithSoftDelete;
use Derhub\Template\AggregateExample\Model\Values\SampleId;

class SampleModel implements MultiTenantAggregateRoot
{
    use UseAggregateRoot;
    use UseTimestampsWithSoftDelete;

    private SampleId $sampleId;

    public function __construct(
        ?SampleId $sampleId
    )
    {
        $this->sampleId = $sampleId ?? new SampleId();
    }

    public function aggregateRootId(): mixed
    {
        return $this->sampleId;
    }
}