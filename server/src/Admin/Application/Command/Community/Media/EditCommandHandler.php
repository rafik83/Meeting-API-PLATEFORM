<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\Community\Media;

use Proximum\Vimeet365\Admin\Application\Event\CommunityMedia\MediaVideoUploadedEvent;
use Proximum\Vimeet365\Common\Messenger\EventBusInterface;
use Proximum\Vimeet365\Core\Application\Filesystem\MediaVideosFilesystemInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Media;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class EditCommandHandler
{
    public function __construct(
        private MediaVideosFilesystemInterface $filesystem,
        private EventBusInterface $eventBus
    ) {
    }

    public function __invoke(EditCommand $command): void
    {
        \assert($command->mediaType !== null);

        $media = $command->getMedia();

        $media->update(
            $command->mediaType,
            $command->tags,
        );

        $localesToRemove = array_diff(array_keys($command->translations), $media->getTranslations()->getKeys());
        foreach ($localesToRemove as $locale) {
            $media->getTranslations()->remove($locale);
        }

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

        $this->updateVideo($media, $command->video);

        if ($media->isPublished() !== $command->published) {
            $media->setPublished($command->published);
        }
    }

    private function updateVideo(Media $media, ?UploadedFile $video): void
    {
        if ($video === null) {
            return;
        }

        if ($media->getVideo() !== null) {
            $this->filesystem->remove($media->getVideo());
        }

        $filename = $this->filesystem->upload($media, $video);

        $media->setVideo($filename);

        $this->eventBus->dispatch(new MediaVideoUploadedEvent((int) $media->getId()));
    }
}
