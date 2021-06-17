<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\Community\Event;

use Proximum\Vimeet365\Core\Domain\Repository\CommunityEventRepositoryInterface;

class DeleteCommandHandler
{
    public function __construct(
        private CommunityEventRepositoryInterface $eventRepository
    ) {
    }

    public function __invoke(DeleteCommand $command): void
    {
        $this->eventRepository->remove($command->getEvent());
    }
}
