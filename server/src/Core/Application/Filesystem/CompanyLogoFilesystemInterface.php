<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Application\Filesystem;

use Proximum\Vimeet365\Core\Domain\Entity\Company;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface CompanyLogoFilesystemInterface
{
    public function upload(Company $company, UploadedFile $file): string;

    public function remove(string $filename): void;
}
