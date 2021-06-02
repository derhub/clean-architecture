# Outbox Pattern
Guaranty the message to be published at least once

### Usage
1. record `DomainEvents` using `OutboxMessageRecorder::recordFromEvent`


2. Run `OutboxMessageRelay:publish`
    - then poll unconsume message 
    - then try to publish them using "EventBus"
    - then if publish succeed mark the message as consume using `OutboxMessageConsumer::
      consume`


3. Handle incoming message (example: from the queue):
    - then check if process using `OutboxMessageProcessor::IsProcess`
    - then if yes skip
    - then if no call handler
    - then mark the message as process using `OutboxMessageProcessor::process`


### OutboxMessageRecorder
store domain events than will later publish using relay.
Domain events will be wrap in OutboxMessage when recorded

### OutboxMessageConsumer
message might be published more than once 
to avoid this we will mark them as consume 
then in relay we will just fetch all the not consume messages


### OutboxMessageRelay
publish messages to queue.

example: `pusblis messages using cron every 2sec`

### OutboxMessageProcessor
messages might publish more than once to avoid this
we will mark the message as process after calling the handler

Resources:

- http://www.kamilgrzybek.com/design/the-outbox-pattern/
- https://exactly-once.github.io/posts/improving-outbox/
- https://event-driven.io/en/outbox_inbox_patterns_and_delivery_guarantees_explained/
