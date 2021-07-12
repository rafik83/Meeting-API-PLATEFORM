<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\Community\Media;

use Proximum\Vimeet365\Core\Domain\Entity\Community\Media;

class DeleteCommand
{
    public function __construct(
        private Media $media
    ) {
    }

    public function getMedia(): Media
    {
        return $this->media;
    }
}
