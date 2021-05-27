<?php

namespace Derhub\Integration\MessageOutbox;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Derhub\Shared\MessageOutbox\MessageSerializer;
use Derhub\Shared\MessageOutbox\OutboxMessage;
use Derhub\Shared\MessageOutbox\OutboxRepository;
use Generator;

class DoctrineOutboxRepository implements OutboxRepository
{
    private const TABLE_NAME = 'outbox_messages';

    private const IS_CONSUME = 1;
    private const NOT_CONSUME = 0;

    /**
     * DoctrineOutboxRepository constructor.
     * @param EntityManager $entityManager
     * @param \Derhub\Shared\MessageOutbox\MessageSerializer $serializer
     */
    public function __construct(
        private EntityManagerInterface $entityManager,
        private MessageSerializer $serializer
    ) {
    }

    private function getConnection(): Connection
    {
        return $this->entityManager->getConnection();
    }

    private function createQueryBuilder(): \Doctrine\DBAL\Query\QueryBuilder
    {
        return $this->getConnection()->createQueryBuilder();
    }

    public function record(OutboxMessage ...$messages): void
    {
        $queryBuilder = $this->createQueryBuilder();
        try {
            foreach ($messages as $message) {
                $queryBuilder
                    ->insert(self::TABLE_NAME)
                    ->values(
                        [
                            'message_id' => $message->id(),
                            'message_type' => $message->messageType(),
                            'message_name' => $message->name(),
                            'version' => $message->version(),
                            'payload' => json_encode(
                                $this->serializer->serialize($message)
                            ),
                        ]
                    )->execute()
                ;
            }
        } catch (Exception $e) {
            throw DoctrineFailedToSaveMessageException::fromThrowable($e);
        }
    }

    public function all(): Generator
    {
        $tableName = self::TABLE_NAME;
        $consumed = self::NOT_CONSUME;
        $sql =
            "SELECT `id`, `payload` FROM `{$tableName}` WHERE `consumed` = {$consumed} ORDER BY `id` ASC LIMIT 5";

        try {
            $queryBuilder = $this->getConnection()->executeQuery($sql);

            while (($row = $queryBuilder->iterateAssociative()) !== false) {
                yield $this->serializer->unSerialize($row['payload']);
            }
        } catch (Exception $e) {
            throw DoctrineFailedToRetrieveMessageException::fromThrowable($e);
        }
    }

    public function markAsConsume(OutboxMessage ...$messages): void
    {
        $messageIds = [];
        foreach ($messages as $message) {
            $messageIds[] = $message->id();
        }

        $tableName = self::TABLE_NAME;
        $consumed = self::IS_CONSUME;
        $sqlStatement =
            "UPDATE `{$tableName}` SET consumed = {$consumed} WHERE `message_id` IN (:ids)";

        try {
            $this->getConnection()->executeQuery(
                $sqlStatement,
                [
                    'ids' => $messageIds,
                ], [
                    'ids' => Connection::PARAM_INT_ARRAY,
                ]
            )
            ;
        } catch (Exception $e) {
            throw DoctrineFailedToRetrieveMessageException::fromThrowable($e);
        }
    }

    public function eraseConsumed(): void
    {
        $tableName = self::TABLE_NAME;
        $consumed = self::IS_CONSUME;
        $sqlStatement =
            "DELETE FROM `{$tableName}` WHERE `consumed` = {$consumed} LIMIT 5";

        try {
            $this->getConnection()->executeQuery($sqlStatement);
        } catch (Exception $e) {
            throw DoctrineFailedToRetrieveMessageException::fromThrowable($e);
        }
    }

    public function clear(): void
    {
        $this->eraseConsumed();
    }
}