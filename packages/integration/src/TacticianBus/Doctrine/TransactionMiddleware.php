<?php

namespace Derhub\Integration\TacticianBus\Doctrine;

use Doctrine\DBAL\Connection;
use League\Tactician\Middleware;

class TransactionMiddleware implements Middleware
{
    /**
     * @var callable():Connection
     */
    private $connection;

    public function __construct(callable $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws \Throwable
     */
    public function execute($command, callable $next): mixed
    {
        $connection = ($this->connection)();
        $connection->beginTransaction();

        try {
            $result = $next($command);

            $connection->commit();
        } catch (\Exception | \Throwable $exception) {
            $connection->rollBack();

            throw $exception;
        }

        return $result;
    }
}
