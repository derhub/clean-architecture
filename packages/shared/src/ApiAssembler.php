<?php

namespace Derhub\Shared;

interface ApiAssembler
{
    /**
     * @param array $fromMessage
     * @param class-string $toMessage
     * @return mixed
     */
    public function transform(array $fromMessage, string $toMessage): mixed;
}
