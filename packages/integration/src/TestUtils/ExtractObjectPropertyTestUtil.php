<?php

namespace Derhub\Integration\TestUtils;

use Derhub\Integration\Mapper\ExtractorCacheHelper;
use Derhub\Integration\Mapper\ObjectPropertyExtractor;

class ExtractObjectPropertyTestUtil
{
    private object $aggregateRoot;
    private array $cache;
    private ObjectPropertyExtractor $extractor;

    public function __construct(object $arProperties)
    {
        $this->cache = [];
        $this->setAggregateRoot($arProperties);

        $this->extractor = new ObjectPropertyExtractor(
            new ExtractorCacheHelper(static fn ($name) => $name)
        );
        $this->extractor->setAllowPrivateProtectedAccess(true);
    }

    public function setAggregateRoot(object $aggregate): void
    {
        $this->aggregateRoot = $aggregate;
    }

    public function getProperties(): array
    {
        if ($this->cache) {
            return $this->cache;
        }


        return $this->cache = $this->extractor->extract($this->aggregateRoot);
    }
}
