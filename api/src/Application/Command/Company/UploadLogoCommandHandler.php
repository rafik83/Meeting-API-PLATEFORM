<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\Command\Company;

use Proximum\Vimeet365\Application\Adapter\Company\LogoUploaderInterface;
use Proximum\Vimeet365\Domain\Entity\Company;

class UploadLogoCommandHandler
{
    private LogoUploaderInterface $logoUploader;

    public function __construct(LogoUploaderInterface $logoUploader)
    {
        $this->logoUploader = $logoUploader;
    }

    public function __invoke(UploadLogoCommand $command): Company
    {
        $company = $command->company;

        if ($command->logo === null) {
            throw new \RuntimeException("Can't be empty if the validation work");
        }

        $filename = $this->logoUploader->upload($company, $command->logo);

        $company->setLogo($filename);

        return $company;
    }
}
