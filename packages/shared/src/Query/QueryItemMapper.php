<?php

namespace Derhub\Shared\Query;

/**
 * @template T
 */
interface QueryItemMapper
{
    /**
     * @return T
     */
    public function fromArray(array $data): mixed;
}