<?php

namespace Derhub\Shared\Database;

interface DBTransaction
{
    public function begin(): void;

    public function commit(): void;

    public function rollback(): void;
    public function transaction(callable $callback): mixed;
}
