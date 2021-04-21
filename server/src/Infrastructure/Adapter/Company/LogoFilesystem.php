<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Adapter\Company;

use Doctrine\Inflector\Inflector;
use Doctrine\Inflector\InflectorFactory;
use League\Flysystem\FilesystemOperator;
use Proximum\Vimeet365\Application\Adapter\Company\LogoFilesystemInterface;
use Proximum\Vimeet365\Domain\Entity\Company;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class LogoFilesystem implements LogoFilesystemInterface
{
    private FilesystemOperator $companyLogosStorage;
    private Inflector $inflector;

    public function __construct(FilesystemOperator $companyLogosStorage)
    {
        $this->companyLogosStorage = $companyLogosStorage;
        $this->inflector = InflectorFactory::create()->build();
    }

    public function upload(Company $company, UploadedFile $file): string
    {
        $extension = $file->guessExtension();
        $pref = $this->inflector->urlize($company->getName()) . '-';
        $filename = uniqid($pref, true) . '.' . $extension;

        $this->companyLogosStorage->write($filename, (string) file_get_contents((string) $file->getRealPath()));

        return $filename;
    }

    public function remove(string $filename): void
    {
        if (!$this->companyLogosStorage->fileExists($filename)) {
            return;
        }

        $this->companyLogosStorage->delete($filename);
    }
}
