<?php

namespace Derhub\Integration\MessageOutbox;

use Derhub\Shared\Message\Event\Event;
use Derhub\Shared\MessageOutbox\MessageOutboxWrapperFactory;
use Derhub\Shared\MessageOutbox\OutboxMessageConsumer;
use Derhub\Shared\MessageOutbox\OutboxMessageRecorder;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Derhub\Shared\MessageOutbox\MessageSerializer;
use Derhub\Shared\MessageOutbox\OutboxMessage;
use Generator;

class DoctrineOutboxRepository implements OutboxMessageConsumer, OutboxMessageRecorder
{
    private const IS_CONSUME = 1;
    private const NOT_CONSUME = 0;
    private const TABLE_NAME = 'outbox_messages';

    /**
     * DoctrineOutboxRepository constructor.
     * @param EntityManager $entityManager
     * @param \Derhub\Shared\MessageOutbox\MessageSerializer $serializer
     * @param \Derhub\Shared\MessageOutbox\MessageOutboxWrapperFactory $factory
     */
    public function __construct(
        private EntityManagerInterface $entityManager,
        private MessageSerializer $serializer,
        private MessageOutboxWrapperFactory $factory,
    ) {
    }

    private function createQueryBuilder(): \Doctrine\DBAL\Query\QueryBuilder
    {
        return $this->getConnection()->createQueryBuilder();
    }

    private function getConnection(): Connection
    {
        return $this->entityManager->getConnection();
    }

    public function consume(OutboxMessage ...$messages): void
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
                ],
                [
                    'ids' => Connection::PARAM_INT_ARRAY,
                ]
            )
            ;
        } catch (Exception $e) {
            throw DoctrineFailedToRetrieveMessageException::fromThrowable($e);
        }
    }

    public function eraseConsumedMessage(): void
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

    public function getUnConsumed(): Generator
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
                            'consume_status' => $message->isConsume()
                                ? self::IS_CONSUME : self::NOT_CONSUME,
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

    public function recordFromEvent(Event ...$events): void
    {
        foreach ($events as $event) {
            $message = $this->factory->create($event);
            $this->record($message);
        }
    }
}
