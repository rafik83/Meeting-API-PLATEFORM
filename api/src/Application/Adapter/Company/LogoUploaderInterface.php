<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\Adapter\Company;

use Proximum\Vimeet365\Domain\Entity\Company;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface LogoUploaderInterface
{
    public function upload(Company $company, UploadedFile $file): string;
}
