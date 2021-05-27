<?php

namespace Tests\Shared\MessageOutbox;

use Derhub\Shared\MessageOutbox\InMemoryOutboxRepository;
use Derhub\Shared\MessageOutbox\MessageSerializer;
use Derhub\Shared\MessageOutbox\OutboxMessage;
use Derhub\Shared\MessageOutbox\OutboxMessageId;
use Derhub\Shared\MessageOutbox\OutboxRepository;
use Derhub\Shared\MessageOutbox\SimpleSerializer;
use PHPUnit\Framework\TestCase;
use Tests\Shared\Fixtures\MessageEventFixture;

class OutboxRepositoryTest extends TestCase
{
    /**
     * @var \Derhub\Shared\MessageOutbox\InMemoryOutboxRepository
     */
    private OutboxRepository $outboxRepo;

    protected function setUp(): void
    {
        parent::setUp();
        $serializer = new SimpleSerializer();
        $this->outboxRepo = new InMemoryOutboxRepository($serializer);
    }

    public function test_it_save_message(): void
    {
        $message = new MessageEventFixture('test');

        $id = OutboxMessageId::generate();
        $messageWrap = new OutboxMessage(
            $id,
            'event',
            'test.event.MessageEventFixture',
            $message,
            ['test' => 1]
        );

        $this->outboxRepo->record($messageWrap);

        foreach ($this->outboxRepo->all() as $item) {
            self::assertEquals($item, $messageWrap);
        }
    }
}
