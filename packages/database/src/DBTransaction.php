<?php

namespace Derhub\Shared\Database;

interface DBTransaction
{
    public function transaction(callable $callback): mixed;

    public function begin(): void;

    public function commit(): void;

    public function rollback(): void;
}
