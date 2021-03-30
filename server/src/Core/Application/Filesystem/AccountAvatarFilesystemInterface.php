<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Application\Filesystem;

use Proximum\Vimeet365\Core\Domain\Entity\Account;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface AccountAvatarFilesystemInterface
{
    public function remove(string $filename): void;

    public function upload(Account $account, UploadedFile $file): string;
}
