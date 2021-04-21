<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Adapter\Account;

use League\Flysystem\FilesystemOperator;
use Proximum\Vimeet365\Application\Adapter\Account\AvatarFilesystemInterface;
use Proximum\Vimeet365\Domain\Entity\Account;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AvatarFilesystem implements AvatarFilesystemInterface
{
    private FilesystemOperator $accountAvatarStorage;

    public function __construct(FilesystemOperator $accountAvatarStorage)
    {
        $this->accountAvatarStorage = $accountAvatarStorage;
    }

    public function remove(string $filename): void
    {
        if (!$this->accountAvatarStorage->fileExists($filename)) {
            return;
        }

        $this->accountAvatarStorage->delete($filename);
    }

    public function upload(Account $account, UploadedFile $file): string
    {
        $extension = $file->guessExtension();
        $pref = $account->getId() . '-';
        $filename = uniqid($pref, true) . '.' . $extension;

        $this->accountAvatarStorage->write($filename, (string) file_get_contents((string) $file->getRealPath()));

        return $filename;
    }
}
