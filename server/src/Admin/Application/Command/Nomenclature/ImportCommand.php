<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\Nomenclature;

use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class ImportCommand
{
    public Nomenclature $nomenclature;

    /**
     * @Assert\NotNull
     * @Assert\File(mimeTypes={"text/csv", "text/plain"})
     */
    public ?UploadedFile $file = null;

    public function __construct(Nomenclature $nomenclature)
    {
        $this->nomenclature = $nomenclature;
    }
}
