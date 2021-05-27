<?php

namespace Derhub\Business\Services;

interface BusinessQueryItemMapper
{
    public function fromArray(array $data): BusinessQueryItem;
}