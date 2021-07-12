<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Event\CommunityMedia;

class MediaVideoUploadedEvent
{
    public function __construct(public int $mediaId)
    {
    }
}
