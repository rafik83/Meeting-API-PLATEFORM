<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Event\CommunityMedia;

use Proximum\Vimeet365\Core\Domain\Repository\CommunityMediaRepositoryInterface;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;

class MediaVideoUploadedEventHandler
{
    public function __construct(
        private CommunityMediaRepositoryInterface $repository
    ) {
    }

    public function __invoke(MediaVideoUploadedEvent $event): void
    {
        $media = $this->repository->findOneById($event->mediaId);

        if ($media === null) {
            throw new UnrecoverableMessageHandlingException(sprintf('The media with id %d does not exists', $event->mediaId));
        }

        // todo process the video & mark as processed the media

        $media->setProcessed(true);
    }
}
