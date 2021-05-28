<?php

namespace Derhub\Shared\Model;

interface Entity
{
    public static function fromArray(array $values): self;

    public function toArray(): array;

    public function sameAs(Entity $other): bool;
}
