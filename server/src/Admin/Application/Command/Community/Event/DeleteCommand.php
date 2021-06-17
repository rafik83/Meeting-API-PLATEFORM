<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\Community\Event;

use Proximum\Vimeet365\Core\Domain\Entity\Community\Event;

class DeleteCommand
{
    public function __construct(
        private Event $event
    ) {
    }

    public function getEvent(): Event
    {
        return $this->event;
    }
}
