<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\Command\Company;

use Proximum\Vimeet365\Application\Adapter\Company\LogoFilesystemInterface;
use Proximum\Vimeet365\Domain\Entity\Company;

class UploadLogoCommandHandler
{
    private LogoFilesystemInterface $logoUploader;

    public function __construct(LogoFilesystemInterface $logoUploader)
    {
        $this->logoUploader = $logoUploader;
    }

    public function __invoke(UploadLogoCommand $command): Company
    {
        $company = $command->company;

        if ($command->logo === null) {
            throw new \RuntimeException("Can't be empty if the validation work");
        }

        if ($company->getLogo() !== null) {
            $this->logoUploader->remove($company->getLogo());
        }

        $filename = $this->logoUploader->upload($company, $command->logo);

        $company->setLogo($filename);

        return $company;
    }
}
