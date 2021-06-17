<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Infrastructure\Filesystem;

use League\Flysystem\FilesystemOperator;
use Proximum\Vimeet365\Core\Application\Filesystem\EventPictureFilesystemInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Event;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class EventPictureFilesystem implements EventPictureFilesystemInterface
{
    private FilesystemOperator $eventPicturesStorage;

    public function __construct(FilesystemOperator $eventPicturesStorage)
    {
        $this->eventPicturesStorage = $eventPicturesStorage;
    }

    public function remove(string $filename): void
    {
        if (!$this->eventPicturesStorage->fileExists($filename)) {
            return;
        }

        $this->eventPicturesStorage->delete($filename);
    }

    public function upload(Event $event, UploadedFile $file): string
    {
        $extension = $file->guessExtension();
        $pref = $event->getId() . '-';
        $filename = uniqid($pref, true) . '.' . $extension;

        $this->eventPicturesStorage->write($filename, (string) file_get_contents((string) $file->getRealPath()));

        return $filename;
    }
}
