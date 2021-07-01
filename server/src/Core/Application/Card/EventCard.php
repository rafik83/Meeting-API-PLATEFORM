<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Application\Card;

use Proximum\Vimeet365\Core\Domain\Entity\Community\Card;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Event;

class EventCard extends Card
{
    public function __construct(
        private Event $event
    ) {
    }

    public function getId(): int
    {
        return (int) $this->event->getId();
    }

    public function getName(): string
    {
        return $this->event->getName();
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->event->getStartDate();
    }

    public function getEvent(): Event
    {
        return $this->event;
    }
}
