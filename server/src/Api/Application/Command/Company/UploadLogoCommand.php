<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Command\Company;

use Proximum\Vimeet365\Core\Domain\Entity\Company;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Validator\Constraints as Assert;

class UploadLogoCommand
{
    /** @Ignore */
    public Company $company;

    /**
     * @Assert\NotNull
     * @Assert\Image(maxSize="1M", mimeTypes={"image/png", "image/jpeg"})
     */
    public ?UploadedFile $logo;

    public function __construct(Company $company, ?UploadedFile $logo)
    {
        $this->company = $company;
        $this->logo = $logo;
    }
}
