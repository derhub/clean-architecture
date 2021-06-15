<?php

namespace Derhub\IdentityAccess\AccessProvider\Model;

interface Role
{
    public function id(): string;

    public function description(): string;

    public function name(): string;

    public function permissions(): array;

    public function isRoot(): bool;

    public function hasPermissions(string|array ...$permissions): bool;
}