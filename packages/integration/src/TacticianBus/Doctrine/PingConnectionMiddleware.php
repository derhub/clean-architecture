<?php

namespace Derhub\Integration\TacticianBus\Doctrine;

use Doctrine\DBAL\Connection;
use League\Tactician\Middleware;

final class PingConnectionMiddleware implements Middleware
{
    /**
     * @var callable():Connection
     */
    private $connection;

    public function __construct(callable $getConnection)
    {
        $this->connection = $getConnection;
    }

    public function execute($command, callable $next): mixed
    {
        $connection = ($this->connection)();
        if (method_exists($connection, 'ping')) {
            if ($connection->ping() === false) {
                $connection->close();
                $connection->connect();
            }
        }

        return $next($command);
    }
}
