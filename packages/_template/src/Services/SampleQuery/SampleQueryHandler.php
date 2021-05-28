<?php

namespace EB\Template\Services\SampleQuery;

use EB\Shared\Message\Query\QueryResponse;
use EB\Shared\Query\Filters\InArrayFilter;
use EB\Template\Infrastructure\Query\TemplateQueryRepository;
use EB\Template\Services\CommonQueryResponse;
use EB\Template\Services\TemplateItemMapper;
use EB\Template\Shared\SharedValues;

class SampleQueryHandler
{
    public function __construct(
        private TemplateQueryRepository $query,
        private TemplateItemMapper $mapper
    ) {
    }

    public function __invoke(SampleQuery $message): QueryResponse
    {
        $query = $this->query->addFilters(
            new InArrayFilter(
                SharedValues::COL_ID,
                $message->aggregateRootIds()
            )
        );

        return (new CommonQueryResponse($this->mapper))
            ->setResults($query->results());
    }
}