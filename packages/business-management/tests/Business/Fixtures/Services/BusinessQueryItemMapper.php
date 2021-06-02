<?php

namespace Tests\BusinessManagement\Business\Fixtures\Services;

use Derhub\BusinessManagement\Business\Services\BusinessQueryItem;

class BusinessQueryItemMapper implements \Derhub\BusinessManagement\Business\Services\BusinessQueryItemMapper
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
