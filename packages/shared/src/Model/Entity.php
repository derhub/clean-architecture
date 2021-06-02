<?php

namespace Derhub\Shared\Model;

interface Entity
{
    public static function fromArray(array $values): self;

    public function sameAs(Entity $other): bool;

    public function toArray(): array;
}
