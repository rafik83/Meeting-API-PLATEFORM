<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\Community\Media;

use Proximum\Vimeet365\Admin\Application\Event\CommunityMedia\MediaVideoUploadedEvent;
use Proximum\Vimeet365\Common\Messenger\EventBusInterface;
use Proximum\Vimeet365\Core\Application\Filesystem\MediaVideosFilesystemInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Media;
use Proximum\Vimeet365\Core\Domain\Repository\CommunityMediaRepositoryInterface;

class CreateCommandHandler
{
    public function __construct(
        private CommunityMediaRepositoryInterface $mediaRepository,
        private MediaVideosFilesystemInterface $filesystem,
        private EventBusInterface $eventBus
    ) {
    }

    public function __invoke(CreateCommand $command): Media
    {
        \assert($command->mediaType !== null);

        $media = new Media($command->getCommunity(), $command->mediaType, $command->tags);

        foreach ($command->translations as $translationDto) {
            \assert($translationDto->name !== null);
            \assert($translationDto->description !== null);

            $media->setTranslation(
                $translationDto->getLanguage(),
                $translationDto->name,
                $translationDto->description,
                $translationDto->ctaLabel,
                $translationDto->ctaUrl
            );
        }

        $media->setPublished($command->published);

        $this->mediaRepository->add($media, true);

        \assert($command->video !== null);
        $filename = $this->filesystem->upload($media, $command->video);
        $media->setVideo($filename);

        $this->eventBus->dispatch(new MediaVideoUploadedEvent((int) $media->getId()));

        return $media;
    }
}
