<?php

namespace Derhub\Shared\Entity;

interface Entity
{
    public static function fromArray(array $values): self;

    public function toArray(): array;

    public function sameAs(Entity $other): bool;
}
