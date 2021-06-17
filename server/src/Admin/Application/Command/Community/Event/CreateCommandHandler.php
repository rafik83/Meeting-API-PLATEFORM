<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\Community\Event;

use Proximum\Vimeet365\Core\Application\Filesystem\EventPictureFilesystemInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Event;
use Proximum\Vimeet365\Core\Domain\Repository\CommunityEventRepositoryInterface;

class CreateCommandHandler
{
    public function __construct(
        private CommunityEventRepositoryInterface $eventRepository,
        private EventPictureFilesystemInterface $filesystem
    ) {
    }

    public function __invoke(CreateCommand $command): Event
    {
        \assert($command->eventType !== null);
        \assert($command->startDate !== null);
        \assert($command->endDate !== null);
        \assert($command->picture !== null);

        $event = new Event(
            $command->getCommunity(),
            $command->name,
            $command->eventType,
            $command->startDate,
            $command->endDate,
            $command->registerUrl,
            $command->findOutMoreUrl,
            $command->tags,
            $command->characterizationTags,
        );

        $event->setPublished($command->published);

        $this->eventRepository->add($event, true);

        $filename = $this->filesystem->upload($event, $command->picture);
        $event->setPicture($filename);

        return $event;
    }
}
