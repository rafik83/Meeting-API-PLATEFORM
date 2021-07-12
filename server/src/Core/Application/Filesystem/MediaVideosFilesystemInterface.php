<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Application\Filesystem;

use Proximum\Vimeet365\Core\Domain\Entity\Community\Media;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface MediaVideosFilesystemInterface
{
    public function remove(string $filename): void;

    public function upload(Media $media, UploadedFile $file): string;
}
