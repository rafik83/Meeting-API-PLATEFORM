<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Application\Card;

use Proximum\Vimeet365\Core\Domain\Entity\Community\Card;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Media;

class MediaCard extends Card
{
    public function __construct(
        private Media $media
    ) {
    }

    public function getId(): int
    {
        return (int) $this->media->getId();
    }

    public function getName(): string
    {
        return (string) $this->media->getTranslation()?->getName();
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->media->getCreatedAt();
    }

    public function getMedia(): Media
    {
        return $this->media;
    }
}
