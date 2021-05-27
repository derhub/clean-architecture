<?php

namespace Tests\Business\Fixtures\Services;

use Derhub\Business\Services\BusinessQueryItem;

class BusinessQueryItemMapper
    implements \Derhub\Business\Services\BusinessQueryItemMapper
{
    private BusinessQueryItem $result;

    public function setResults(BusinessQueryItem $item): self
    {
        $this->result = $item;

        return $this;
    }

    public function fromArray(array $data): BusinessQueryItem
    {
        return $this->result;
    }
}