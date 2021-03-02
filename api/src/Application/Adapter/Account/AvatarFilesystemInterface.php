<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\Adapter\Account;

use Proximum\Vimeet365\Domain\Entity\Account;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface AvatarFilesystemInterface
{
    public function remove(string $filename): void;

    public function upload(Account $account, UploadedFile $file): string;
}
