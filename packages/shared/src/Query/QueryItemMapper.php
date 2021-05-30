<?php

namespace Derhub\Shared\Query;

/**
 * @template T as QueryItem
 */
interface QueryItemMapper
{
    /**
     * @return T
     */
    public function fromArray(array $data): QueryItem;
}