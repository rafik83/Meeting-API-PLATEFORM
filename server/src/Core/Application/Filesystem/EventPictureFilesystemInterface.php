<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Application\Filesystem;

use Proximum\Vimeet365\Core\Domain\Entity\Community\Event;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface EventPictureFilesystemInterface
{
    public function remove(string $filename): void;

    public function upload(Event $event, UploadedFile $file): string;
}
