<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\Community\Event;

use Proximum\Vimeet365\Core\Application\Filesystem\EventPictureFilesystemInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Event;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class EditCommandHandler
{
    public function __construct(
        private EventPictureFilesystemInterface $filesystem
    ) {
    }

    public function __invoke(EditCommand $command): void
    {
        \assert($command->startDate != null);
        \assert($command->endDate != null);

        $event = $command->getEvent();

        $event->update(
            $command->name,
            $command->eventType,
            $command->startDate,
            $command->endDate,
            $command->registerUrl,
            $command->findOutMoreUrl,
            $command->tags,
            $command->characterizationTags
        );

        $this->updatePicture($event, $command->picture);

        if ($event->isPublished() !== $command->published) {
            $event->setPublished($command->published);
        }
    }

    private function updatePicture(Event $event, ?UploadedFile $picture): void
    {
        if ($picture === null) {
            return;
        }

        if ($event->getPicture() !== null) {
            $this->filesystem->remove($event->getPicture());
        }

        $filename = $this->filesystem->upload($event, $picture);

        $event->setPicture($filename);
    }
}
