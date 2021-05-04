<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Common\Messenger;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;

class EventBus implements EventBusInterface
{
    /** @var MessageBusInterface */
    private $eventBus;

    public function __construct(MessageBusInterface $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    /**
     * Dispatches an event in a new transaction (after any other message being dispatched beforehand was handled successfully).
     * It's not mandatory but most events are handled asynchronously.
     *
     * @see https://symfony.com/doc/current/messenger/message-recorder.html about transactional dispatch
     *
     * @param bool $transactional Set it to false if you're not invoking the dispatch method from a handler
     */
    public function dispatch(object $event, bool $transactional = true): void
    {
        if ($transactional) {
            $envelope = Envelope::wrap($event, [
                // See https://symfony.com/doc/current/messenger/message-recorder.html
                new DispatchAfterCurrentBusStamp(),
            ]);
        }

        $this->eventBus->dispatch($envelope ?? $event);
    }
}
