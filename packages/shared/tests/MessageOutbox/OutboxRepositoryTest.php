<?php

namespace Tests\Shared\MessageOutbox;

use Derhub\Shared\MessageOutbox\EventOutboxMessageFactory;
use Derhub\Shared\MessageOutbox\InMemory\InMemoryOutboxMessageWrapper;
use Derhub\Shared\MessageOutbox\InMemory\InMemoryOutboxRepository;
use Derhub\Shared\MessageOutbox\OutboxMessage;
use Derhub\Shared\MessageOutbox\OutboxMessageId;
use Derhub\Shared\MessageOutbox\OutboxMessageRepository;
use Derhub\Shared\MessageOutbox\SimpleSerializer;
use PHPUnit\Framework\TestCase;
use Tests\Shared\Fixtures\MessageEventFixture;

class OutboxRepositoryTest extends TestCase
{
    private OutboxMessageRepository $outboxRepo;

    protected function setUp(): void
    {
        parent::setUp();
        $serializer = new SimpleSerializer();
        $this->outboxRepo = new InMemoryOutboxRepository($serializer, new InMemoryOutboxMessageWrapper());
    }

    public function test_it_save_message(): void
    {
        $message = new MessageEventFixture('test');

        $id = OutboxMessageId::generate();
        $messageWrap = new OutboxMessage(
            $id,
            'event',
            'test.event.MessageEventFixture',
            false,
            $message,
            ['test' => 1]
        );

        $this->outboxRepo->record($messageWrap);

        foreach ($this->outboxRepo->getUnConsumed() as $item) {
            self::assertEquals($item, $messageWrap);
        }
    }
}
