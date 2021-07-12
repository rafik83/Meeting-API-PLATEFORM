<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Infrastructure\Filesystem;

use League\Flysystem\FilesystemOperator;
use Proximum\Vimeet365\Core\Application\Filesystem\MediaVideosFilesystemInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Media;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MediaVideosFilesystem implements MediaVideosFilesystemInterface
{
    private FilesystemOperator $mediaVideosStorage;

    public function __construct(FilesystemOperator $mediaVideosStorage)
    {
        $this->mediaVideosStorage = $mediaVideosStorage;
    }

    public function remove(string $filename): void
    {
        if (!$this->mediaVideosStorage->fileExists($filename)) {
            return;
        }

        $this->mediaVideosStorage->delete($filename);
    }

    public function upload(Media $media, UploadedFile $file): string
    {
        $extension = $file->guessExtension();
        $pref = $media->getId() . '-';
        $filename = uniqid($pref, true) . '.' . $extension;

        $this->mediaVideosStorage->write($filename, (string) file_get_contents((string) $file->getRealPath()));

        return $filename;
    }
}
